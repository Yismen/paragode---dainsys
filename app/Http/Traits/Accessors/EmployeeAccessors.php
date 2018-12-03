<?php

namespace App\Http\Traits\Accessors;

use App\Afp;
use App\Ars;
use App\Bank;
use App\Gender;
use App\System;
use App\Marital;
use App\Position;
use Carbon\Carbon;
use App\Department;
use App\Supervisor;
use App\Nationality;
use App\TerminationType;
use App\TerminationReason;

trait EmployeeAccessors
{
    /**
     * return a list array of the systems, including name and id
     * @return array a list of systems registered.
     */
    public function getNationalitiesListAttribute()
    {
        return Nationality::orderBy('name')->pluck('name', 'id');
    }

    public function getNationalityAttribute()
    {
        return $this->nationalities()->first();
    }

    public function getArsListAttribute()
    {
        return Ars::orderBy('name')->get();
    }

    public function getAfpListAttribute()
    {
        return Afp::orderBy('name')->pluck('name', 'id');
    }

    public function getSupervisorsListAttribute()
    {
        return Supervisor::orderBy('name')->select('id', 'name')->get();
    }

    public function getBanksListAttribute()
    {
        return Bank::orderBy('name')->pluck('name', 'id');
    }

    public function getCurrentSupervisorAttribute()
    {
        return $this->supervisor()->pluck('id');
    }

    public function getSystemsListAttribute()
    {
        return System::pluck('display_name', 'id');
    }

    public function getPhotoAttribute($photo)
    {
        return $photo == '' ? 'http://placehold.it/300x300' : $photo;
    }

    /**
     * determine if the user is active or inactive
     * @return string user status
     */
    public function getStatusAttribute()
    {
        return $this->termination ? 'Inactive' : 'Active';
    }

    /**
     * set the active attribute
     * @return  boolean   if user has termination
     */
    public function getActiveAttribute()
    {
        return $this->termination == false;
    }

    /**
     * Concatanets firs name and last name attributes
     * @return  string  first and last names joint by space
     */
    public function getFullNameAttribute()
    {
        $name = $this->first_name . ' ' . $this->second_first_name . ' ' . $this->last_name . ' ' . $this->second_last_name;
        return ucwords(trim(mb_strtolower($name)));
    }

    /**
     * Return a new instance for the date
     * @param  [type] $date [description]
     * @return [type]       [description]
     */
    // public function getHireDateAttribute($date)
    // {
    //  return Carbon::parse($date)->format('Y-m-d h:i:s');
    // }

    // public function getDateOfBirthAttribute($date)
    // {
    //  return Carbon::parse($date)->format('Y-m-d h:i:s');
    // }

    /**
     * Convert the Date of birth to date
     * @param  datetime $date employee date of birth
     * @return datetime       an instance of carbon
     */
    // public function getDateOfBirthAttribute($date)
    // {
    //  return Carbon::parse($date)->format('Y-m-d');
    // }

    /**
     * define the attribute can be rehired
     * @return boolean whether or not the
     */
    public function getCanBeRehiredAttribute()
    {
        return $this->termination ? $this->termination->can_be_rehired : null;
    }

    public function getTerminationDateAttribute()
    {
        return !$this->termination ? Carbon::now()->format('Y-m-d') : Carbon::parse($this->termination->termination_date)->format('Y-m-d');
    }

    public function getTerminationTypeIdAttribute()
    {
        return $this->termination ? $this->termination->terminationType->id : null;
    }

    public function getTerminationTypeListAttribute()
    {
        return $this->termination ? $this->termination->terminationType->orderBy('name')->pluck('name', 'id') : TerminationType::orderBy('name')->pluck('name', 'id');
    }

    public function getTerminationReasonIdAttribute()
    {
        return $this->termination ? $this->termination->terminationType->id : null;
    }

    public function getTerminationReasonListAttribute()
    {
        return $this->termination ? $this->termination->terminationReason->pluck('reason', 'id') : TerminationReason::pluck('reason', 'id');
    }

    /**
     * convert the First Name to UC Words
     * @param  String $first_name Employee First name
     * @return String             Converted to ucwords
     */
    public function getFirstNameAttribute($name)
    {
        return ucwords(mb_strtolower($name));
    }

    public function getSecondFirstNameAttribute($name)
    {
        return ucwords(mb_strtolower($name));
    }

    /**
     * convert the First Name to UC Words
     * @param  String $first_name Employee First name
     * @return String             Converted to ucwords
     */
    public function getLastNameAttribute($name)
    {
        return ucwords(mb_strtolower($name));
    }

    public function getSecondLastNameAttribute($name)
    {
        return ucwords(mb_strtolower($name));
    }

    /**
     * list the has kids attribute
     *
     * @return array
     */
    public function getHasKidsListAttribute()
    {
        return ['0' => 'No', '1' => 'Yes'];
    }

    public function getDepartmentsListAttribute()
    {
        return Department::orderBy('department')->pluck('department', 'id');
    }

    /**
     * List all the Genders model
     *
     * @return [array] [description]
     */
    public function getGendersListAttribute()
    {
        return Gender::pluck('gender', 'id');
    }

    public function getMaritalsListAttribute()
    {
        return Marital::orderBy('name')->pluck('name', 'id');
    }

    /**
     * List all the departments
     *
     * @return array [description]
     */
    public function getPositionsListAttribute()
    {
        return  Position::orderBy('department_id')->with('department', 'payment_type', 'payment_frequency')->get();
    }
}
