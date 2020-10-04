<?php

use Illuminate\Database\Seeder;

use App\Models\Insurance;
class InsurancesTableSeeder extends Seeder
{

    public $insurances = [
    'ACA SALUD',
    'AGUA Y ENERGIA (ENERGIA SALUD)',
    'AMOEIAG ( MUTUAL DE SUTIAGA)',
    'AMUR',
    'APM (Agente de Propag. Médica)',
    'ARGUS SALUD',
    'ASOC. TRABAJADORES DE FARMACIA',
    'BARRIDO Y LIMPIEZA',
    'CAJA DE INGENIEROS',
    'CAJA FORENSE',
    'CIENCIAS ECONÓMICAS',
    'CTRO. ASISTENCIAL RAFAELA',
    'D.A.S. (Congreso de la Nación)',
    'DASUTeN',
    'ENSALUD (OSOETSYL – OSPACP)',
    'ESENCIAL',
    'FEDERADA SALUD',
    'FESALUD',
    'FIDEISALUD (OSCEP) (OSSdeB) (ASSPE)',
    'GALENO',
    'GASTRONÓMICOS',
    'IAPOS',
    'INTEGRAL SALUD PLAN BÁSICO',
    'INTEGRAL SALUD PLAN CEIBO',
    'IOSE',
    'IOSE DIBA (Dirección de Salud y Acción Social de la Armada)',
    'IOSE DIBPFA (Dirección general de Bienestar del Personal Fuerza Aérea)',
    'IOSE IOSFA (Instituto Obra Social de las Fuerzas Armadas)',
    'ITER MEDICINA (OSPEDICI) (OSPACA) (OSPM PERSONAL MARITIMO) OSAM(MINEROS)',
    'JERÁRQUICOS SALUD',
    'LUIS PASTEUR',
    'LUZ Y FUERZA',
    'MEDICUS',
    'MEDIFE BRONCE',
    'MEDIFE ORO',
    'MEDIFE PLATA',
    'OMINT',
    'OPDEA',
    'OS DEL PERSONAL AUXILIAR DE CASAS PARTICULARES',
    'OS EMPLEADO TINTORERO Y SOMBRERERO.',
    'OSCEP O.S. Capataces y Estibadores Portuarios',
    'OSCRAIA',
    'OSDE (Convenio Sanatorial)',
    'OSECAL',
    'OSETYA',
    'OSFFENTOS',
    'OSPAC (Arte de Curar)',
    'OSPACARP (GRUPO SAN NICOLAS)',
    'OSPACARP O.S. Patrones de Cabotaje',
    'OSPAT',
    'OSPE',
    'OSPECON',
    'OSPEDYC (Convenio Sanatorial)',
    'OSPEGAP',
    'OSPESGA',
    'OSPIL',
    'OSPIM (Ind. De la madera)',
    'OSPIQyP Ind. Química y Petroquímica',
    'OSPTV(SAT)',
    'OSSDeB O.S. de Serenos de Buques',
    'PAPEL, CARTÓN Y QUÍMICOS',
    'Particular',
    'Personal de Farmacia',
    'Poder Judicial',
    'Prevención Salud A3',
    'Prevención Salud A4',
    'Prevención Salud A5',
    'Prevención Salud A6',
    'S.A.T',
    'SADAIC (Sin bono de consulta)',
    'Sancor 2500 FEMA (Fundación Empresaria Maderera)',
    'Sancor 500',
    'Sancor Medicina Privada',
    'SCIS OPSCRA',
    'SCIS OSPACA CERVECEROS SC100 Y SC250',
    'SCIS OSTRAC',
    'SCIS OSTYR/AATRAC/OSTEP (SC100)',
    'SM SALUD',
    'SUTIAGA – AMOEIAG',
    'Swiss Medical',
    'Swiss Medical – Planes Docthos'
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->createRandomInsurances(20);
        $this->createAllInsurances();
    }

    public function createRandomInsurances($n) {
        $insurances = $this->insurances;
        
        $keys = array_rand($insurances, $n);

        foreach($keys as $key){
            $insurance = Insurance::create([
                'name' => $insurances[$key],
                'short_name' => $insurances[$key],
                'enabled' => 1,
                'patient_enabled' => 1
                ]);
        }
    }

    public function createAllInsurances(){
        $insurances = $this->insurances;

        foreach($insurances as $insurance) {
            $insurance = Insurance::create([
                'name' => $insurance,
                'short_name' => $insurance,
                'enabled' => 1,
                'patient_enabled' => 1
                ]);
        }
    }
}