<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['department'];

    /**
     * Update the Department name field to be ucwords
     *
     * @param  [string] $department the department name's field
     * @return string             converted string
     */
    public function setDepartmentAttribute($department)
    {
        return $this->attributes['department'] = ucwords($department);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    /**
     * many to many relationship with the employee model
     * @return [array] [employees associated to current Department]
     */
    public function employees()
    {
        return $this->hasManyThrough(Employee::class, Position::class);
    }

    /**
     * Return the count of employees assigned to the current department
     * @return integer Count of employees assigned to the current department
     */
    public function employees_count()
    {
        return $this->employees()->count();
    }
}
