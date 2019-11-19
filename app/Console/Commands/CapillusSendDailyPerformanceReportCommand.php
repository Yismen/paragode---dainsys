<?php

namespace App\Console\Commands;

use App\CapillusDailyPerformance;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\Capillus\CapillusDailyLogTimeMail;
use App\Exports\Capillus\CapillusAgentLogTimeExport;
use App\Exports\Capillus\CapillusPerformanceReportExport;
use App\Repositories\Capillus\CapillusPerformanceReportRepository;
use Illuminate\Support\Facades\Mail;

class CapillusSendDailyPerformanceReportCommand extends Command
{
    use CapillusCommandsTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dainsys:capillus-send-daily-permance-report {--date=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Capillus - send daily performance report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $instance = Carbon::now()->format('Ymd_His');
            $file_name = "Capillus Daily Performance Report {$instance}.xlsx";

            $date = $this->option('date') == 'default' ? 
                Carbon::now()->subDay() : 
                Carbon::parse($this->option('date'));

            Excel::store(new CapillusPerformanceReportExport($date), $file_name);

            dd("df");




            Mail::send(
                new CapillusFlashMail($this->distroList(), $file_name, "KNYC E Flash")
            );
    
            $this->info("Capillus lash report sent!");

            // Log::info($mtd->sum('calls_offered'));
            // Get the daily data for the week
            // Sumarize the WTD Data
            // Summarize the MTD Data

            // Construct the excel file

            // Send the file in an attachment

            // Remove the file

        } catch (\Throwable $th) {
            Log::error($th);
        }        
    }

    protected function getArrayFields($results)
    {
        return [
            'calls_offered' => $results['Calls Offered'],
            'calls_answered' => $results['Calls Answered'],
            'short_abandons' => $results['Short Abandons'],
            'long_abandons' => $results['Long Abandons'],
            'cap_ultra' => $results['Cap Ultra'],
            'date' => $results['DATE'],
            'cap_plus' => $results['Cap Plus'],
            'cap_pro' => $results['Cap Pro'],
            'total_revenue' => $results['Total Revenue'],
            'inbound_minutes' => $results['Inbound Minutes'],
            'call_back' => $results['Call Back'],
            'caller_hung_up_after_pitch' => $results['Caller Hung Up After Pitch'],
            'doesn_t_have_a_credit_debit_card_paypal' => $results['Doesn t Have a Credit   Debit Card   PayPal'],
            'doesn_t_want_to_pay_with_credit_debit_card' => $results['Doesn t Want to Pay With Credit   Debit Card'],
            'insufficient_funds' => $results['Insufficient Funds'],
            'just_wants_information' => $results['Just Wants Information'],
            'misunderstood_offer' => $results['Misunderstood Offer'],
            'needs_to_speak_with_spouse' => $results['Needs to Speak With Spouse'],
            'not_interested' => $results['Not Interested'],
            'sent_to_web_for_financing_no_sale_secured' => $results['Sent to Web for Financing - No Sale Secured'],
            'too_expensive' => $results['Too Expensive'],
            'will_think_about_it' => $results['Will Think About It'],
            'already_a_customer' => $results['Already a Customer'],
            'caller_hung_up_less_than_20_sec' => $results['Caller Hung Up (Less than 20 Sec)'],
            'customer_care_after_hours' => $results['Customer Care (After Hours)'],
            'dead_air' => $results['Dead Air'],
            'do_not_call' => $results['Do Not Call'],
            'fax_machine_telephone_problem' => $results['Fax Machine   Telephone Problem'],
            'language_barrier' => $results['Language Barrier'],
            'other_catchall' => $results['Other (Catch-All)'],
            'prank_call' => $results['Prank Call'],
            'test_call' => $results['Test Call'],
            'transfer_customer_service_question_issue' => $results['Transfer (Customer Service Question Issue)'],
            'transfer_physician_doctor' => $results['Transfer (Physician   Doctor)'],
            'wrong_number' => $results['Wrong Number'],
        ];
    }
}
