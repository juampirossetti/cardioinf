<?php

namespace App\Repositories;

use App\Models\Patient;
use InfyOm\Generator\Common\BaseRepository;

use App\Helpers\ViewFormatter;

use App\Models\User;

use App\Models\Role;
class PatientRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'surname',
        'dni'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Patient::class;
    }

    /*
     * Get array of patients in the form [id] => Name Surname
     */
    public static function getPatientsForSelect(){
        
        $patients = Patient::all();
        return ViewFormatter::getArrayForSelect($patients, 'id', 'name', 'surname');
    }

    public static function findByDni($dni) {
        $patient = Patient::where('dni', $dni)->first();

        return $patient;
    }

    public function updateEmail($email, $id){
        $patient = Patient::find($id);
        $user = $patient->user;
        if($email == ""){
            if($user != null){
                $user->delete();
            }
        } else {
            if($user != null){
                $user->email = $email;
                $user->save();
            } else {
                $attributes = [
                    'name' => $patient->name,
                    'email' => $email,
                    'password' => bcrypt(rand(100000,999999)),
                    'api_token' => str_random(60)];
                
                $new_user = $this->createPatientUser($attributes, $id);
            }
        }
    }

    public function createPatientUser($attributes, $patient_id) {
        $role_patient = Role::where('name', 'patient')->first();
        
        $new_user = User::create($attributes);
        $new_user->attachRole($role_patient);
        $new_user->patient_id = $patient_id;
        $new_user->save();

        return $new_user;

    }

    public function filter(array $filters, $qty = 20){
        
        $query = (new Patient)->newQuery();

        //start date
        if (array_key_exists('dni', $filters)) {
            $query->where('dni', 'like', $filters['dni']. '%');
        }

        if (array_key_exists('surname', $filters)) {
            $query->where('surname', 'like', $filters['surname']. '%');
        }

        if (array_key_exists('name', $filters)) {
            $query->where('name', 'like', $filters['name']. '%');
        }

        $patients = $query->take($qty)->get();

        return $patients;
    }

    public function select2Search($params, $searchField){
        
        if($searchField == 'name') $search = 'patient_name';
        if($searchField == 'surname') $search = 'patient_surname';
        if($searchField == 'dni') $search = 'patient_dni';
        
        $patients = \DB::table('appointments')
                        ->where('status','!=',0)
                        ->whereNotNull($search)
                        ->where($search, '!=','')
                        ->where($search,'LIKE','%'.$params.'%')
                        ->groupBy($search)
                        //->select(['appointments.'.$search, 'id'])
                        ->select(\DB::raw($search.', max(id) as id'))
                        ->get();

        return $patients;
    }

    public function updatePatientFromAppointment($data, $patient_id){

        $patient = Patient::find($patient_id);

        if($patient != null){
            $update = [
            'name' => isset($data['patient_name']) ? $data['patient_name'] : null,
            'surname' => isset($data['patient_surname']) ? $data['patient_surname'] : null,
            'dni' => isset($data['patient_dni']) ? $data['patient_dni'] : null,
            'address' => isset($data['patient_address']) ? $data['patient_address'] : null,
            'primary_phone' => isset($data['patient_primary_phone']) ? $data['patient_primary_phone'] : null,
            'secondary_phone' => isset($data['patient_secondary_phone']) ? $data['patient_secondary_phone'] : null,
            'insurance_id' => isset($data['patient_insurance_id']) ? $data['patient_insurance_id'] : null,
            'professional' => isset($data['patient_professional']) ? $data['patient_professional'] : null,
            'plan' => isset($data['patient_plan']) ? $data['patient_plan'] : null,
            'affiliate_number' => isset($data['patient_affiliate_number']) ? $data['patient_affiliate_number'] : null
            ]; 
            $patient->update($update);
            $patient->save();   
        }

        return $patient;
    }

}
