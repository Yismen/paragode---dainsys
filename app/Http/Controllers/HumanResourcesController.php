<?php namespace App\Http\Controllers;

use App\Employee;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\Employees;
use App\Http\Controllers\Controller;
use App\Repositories\HumanResources\Lists;
use App\Repositories\HumanResources\Issues;
use App\Repositories\HumanResources\Birthdays;
use App\Repositories\HumanResources\Employees\Count;
use App\Repositories\HumanResources\Employees\Reports;

class HumanResourcesController extends Controller 
{
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $hc_by_department = Count::byDepartment();
        $issues = Issues::render();

        $birthdays = $this->getBirthdays();

        $by_status = [
            'actives' => Employee::actives()->count(),
            'inactives' => Employee::inactives()->count(),
        ];

        $by_department_positions = Count::byDepartmentPositionGender()->get();

        $rotationByMonth = collect([
            'in' => Count::inByMonths(5), 
            'out' => Count::outByMonths(5), 
        ]);

        return view('human_resources.index', compact(
            'issues', 'birthdays', 'by_status', 'by_department_positions', 'inByMonth', 'outByMonth', 'rotationByMonth', 'hc_by_department'
        ));
    }

    public function missingArs()
    {
        $employees = Lists::missingArs()->paginate(25);

        return view('human_resources.issues.missing_ars', compact('employees'));
    }

    public function missingAfp()
    {
        $employees = Lists::missingAfp()->paginate(25);

        return view('human_resources.issues.missing_afp', compact('employees'));
    }

    public function missingPhoto()
    {
        $employees = Lists::missingPhoto()->paginate(25);

        return view('human_resources.issues.missing_photo', compact('employees'));
    }

    public function missingAddress()
    {
        $employees = Lists::missingAddress()->paginate(25);

        return view('human_resources.issues.missing_address', compact('employees'));
    }

    public function missingPunch()
    {
        $employees = Lists::missingPunch()->paginate(25);

        return view('human_resources.issues.missing_punch', compact('employees'));
    }

    public function missingSocialSecurity()
    {
        $employees = Lists::missingSocialSecurity()->paginate(25);

        return view('human_resources.issues.missing_social_security', compact('employees'));
    }

    public function missingBankAccount()
    {
        $employees = Lists::missingBankAccount()->paginate(25);

        return view('human_resources.issues.missing_bank_account', compact('employees'));
    }

    public function getBirthdays()
    {
        return [
            'today'      => Birthdays::onDate()->get(),
            'last_month' => Birthdays::lastMonth()->count(),
            'this_month' => Birthdays::currentMonth()->count(),
            'next_month' => Birthdays::nextMonth()->count(),
        ];
    }

    public function birthdaysThisMonth()
    {
        $employees = Birthdays::currentMonth()->paginate(25);

        return view('human_resources.birthdays.this_month', compact('employees'));
    }

    public function birthdaysNextMonth()
    {
        $employees = Birthdays::nextMonth()->paginate(25);

        return view('human_resources.birthdays.next_month', compact('employees'));
    }

    public function birthdaysLastMonth()
    {
        $employees = Birthdays::lastMonth()->paginate(25);

        return view('human_resources.birthdays.last_month', compact('employees'));
    }

    public function dgt3()
    {
        return view('human_resources.reports.dgt3');
    }

    public function handleDgt3(Request $request, Reports $report)
    {
        $this->validate($request, [
            'year' => 'required|integer'
            ]);        

        $results = $report->dgt3($request->year)->get();

        $request->flash();

        return view('human_resources.reports.dgt3', compact('results'));
    }

    public function dgt4(Reports $report)
    {

        return view('human_resources.reports.dgt4');
    }

    public function handleDgt4(Request $request, Reports $report)
    {
        $this->validate($request, [
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12',
            ]);        

        $results = $report->dgt4($request->year, $request->month)->get();

        $request->flash();

        return view('human_resources.reports.dgt4', compact('results'));
    }

    public function byDepartment($id, Employees $employees)
    {
        $department = $employees->employeesByDepartment($id);

        return view('human_resources.hc.by_departments', compact('department'));     
    }

    public function byPosition($id, Employees $employees)
    {
        $position = $employees->employeesByPosition($id);

        return view('human_resources.hc.by_positions', compact('position'));  
    }
    
}
