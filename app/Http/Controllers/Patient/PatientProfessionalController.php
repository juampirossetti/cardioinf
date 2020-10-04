<?php

namespace App\Http\Controllers\Patient;

use App\DataTables\PatientProfessionalDataTable;

use App\Repositories\ProfessionalRepository;
use App\Http\Controllers\AppBaseController;

class PatientProfessionalController extends AppBaseController
{
    /** @var  ProfessionalRepository */
    private $professionalRepository;

    public function __construct(ProfessionalRepository $professionalRepo)
    {
        $this->professionalRepository = $professionalRepo;
    }

    /**
     * Display a listing of the Professional.
     *
     * @param ProfessionalDataTable $professionalDataTable
     * @return Response
     */
    public function index(PatientProfessionalDataTable $professionalDataTable)
    {
        return $professionalDataTable->with('role', 'patient')->render('patient_section.professionals.index');
    }
}
