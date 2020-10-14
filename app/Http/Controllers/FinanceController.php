<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Cost;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Statistic;
use App\Http\Requests;
use \Breadcrumbs;
use \Permissions;
use \DB;
use Carbon\Carbon;

class FinanceController extends Controller
{


    public function countProjects($projects)
    {
        $values  = ['no' => 0, 'revenue' => 0, 'profit' => 0, 'cost' => 0];
        $value = 0;
        $cost = 0;
        $sum = $projects->count();

        // dump($projects);

        foreach( $projects as $project ) {
            $value += $project->costs->sum('value');
            $cost += $project->costs->sum('cost');
        }
        $profit = $value - $cost;
        $array['no'] = $sum;
        $array['revenue'] =  number_format($value);
        $array['cost'] =  number_format($cost);
        $array['profit'] =  number_format($profit);

        if($sum != 0){
            $array['revenue_avg'] = number_format($value/$sum,0);
            $array['cost_avg'] =  number_format($cost/$sum,0);
            $array['profit_avg'] =  number_format($profit/$sum,0);
        }else{
            $array['revenue_avg'] = 0;
            $array['cost_avg'] =  0;
            $array['profit_avg'] =  0;
        }

        return $array;
    }

    public function index(Request $request) {

        Breadcrumbs::push(trans('finance.title'), route('finance.index'));

        $check_prospects = false;
        $check_active = true;
        $check_lost = false;
        $check_complete = true;
        //
        // $check_prospects = $request->get('check_prospects', 0);
        // $check_active = $request->get('check_active', 1);
        // $check_lost = $request->get('check_lost', 0);
        // $check_complete = $request->get('check_complete', 1);

        if( Permissions::has('finance', 'view') ) {

            $rules = [
                'start_date'    => 'date_format:Y-m',
                'end_date'      => 'date_format:Y-m',
            ];

            $this->validate($request, $rules);

            $sales = [];
            $prospects = 0;
            $converted = 0;
            $revenue = 0;
            $profit = 0;

            //SUM values
            // no, revenue, profit, costs - each array fields // see $this->countProjects
            $prospectsSum  = ['no' => 0, 'revenue' => 0, 'profit' => 0, 'cost' => 0];
            $activeSum     = ['no' => 0, 'revenue' => 0, 'profit' => 0, 'cost' => 0];
            $lostSum       = ['no' => 0, 'revenue' => 0, 'profit' => 0, 'cost' => 0];
            $completedSum  = ['no' => 0, 'revenue' => 0, 'profit' => 0, 'cost' => 0];



            //AVG values


            // dump($start_full_date_string);
            $start_date_string = $request->input('start_date', Carbon::now()->subMonths(6)->startOfMonth()->format('Y-m'));
            $end_date_string = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m'));

            $start_date = Carbon::createFromFormat('Y-m', $start_date_string)->startOfMonth();
            $end_date = Carbon::createFromFormat('Y-m', $end_date_string);

            $start_full_date_string = Carbon::createFromFormat('Y-m', $start_date_string)->startOfMonth();
            $end_full_date_string = Carbon::createFromFormat('Y-m', $end_date_string)->endOfMonth();

            $from = $start_date->copy();

            $per_month = [];

            while( $from->lt($end_date) ) {
                $month_stats = [
                    'prospects' => 0,
                    'converted' => 0,
                    'revenue' => 0,
                    'profit' => 0,
                    'prospectsSum'  => ['no' => 0, 'revenue' => 0, 'profit' => 0, 'cost' => 0],
                    'activeSum'     => ['no' => 0, 'revenue' => 0, 'profit' => 0, 'cost' => 0],
                    'lostSum'       => ['no' => 0, 'revenue' => 0, 'profit' => 0, 'cost' => 0],
                    'completedSum'  => ['no' => 0, 'revenue' => 0, 'profit' => 0, 'cost' => 0],
                ];

                $to = $from->copy()->endOfMonth();
                // $to = $end_date;


                // get selected types
                // if($check_prospects)
                $prospects += Project::prospects()->whereBetween('created_at', [$from, $to])->external()->count();

                if($check_active){
                    $c = Project::active()->whereBetween('conversion_date', [$from, $to])->external()->count();
                    $converted += $c;
                    $month_stats['converted'] += $c;
                    // dump(Project::active()->whereBetween('conversion_date', [$from, $to])->count());
                }

                if($check_lost){
                    $c = Project::lost()->whereBetween('conversion_date', [$from, $to])->external()->count();
                    $converted += $c;
                    $month_stats['converted'] += $c;
                }

                if($check_complete){
                    $c = Project::complete()->whereBetween('conversion_date', [$from, $to])->external()->count();
                    $converted += $c;
                    $month_stats['converted'] += $c;
                    // dump(Project::complete()->whereBetween('conversion_date', [$from, $to])->count());
                }


                // $converted += Project::converted()->whereBetween('created_at', [$from, $to])->count();



                $sales_for_month = collect();

                if($check_prospects){
                    $sales_for_month_temp = Project::prospects()->whereBetween('created_at', [$from, $to])->external()->with('costs')->get();
                    foreach ($sales_for_month_temp as $project) {
                        $sales_for_month->push($project);
                    }
                    // $prospects += Project::prospects()->whereBetween('created_at', [$from, $to])->count();
                }

                if($check_active){
                    $sales_for_month_temp = Project::active()->whereBetween('conversion_date', [$from, $to])->external()->with('costs')->get();
                    // dump($sales_for_month_temp->count());
                    foreach ($sales_for_month_temp as $project) {
                        $sales_for_month->push($project);
                    }
                }

                if($check_lost){
                    $sales_for_month_temp = Project::lost()->whereBetween('conversion_date', [$from, $to])->external()->with('costs')->get();
                    foreach ($sales_for_month_temp as $project) {
                        $sales_for_month->push($project);
                    }
                }

                if($check_complete){
                    $sales_for_month_temp = Project::complete()->whereBetween('conversion_date', [$from, $to])->external()->with('costs')->get();
                    // dump($sales_for_month_temp->count());
                    foreach ($sales_for_month_temp as $project) {
                        $sales_for_month->push($project);
                    }
                }

                // $sales_for_month = Project::converted()->whereBetween('conversion_date', [$from, $to])->with('costs')->get();

                // dd($sales_for_month);

                $value = 0;
                $cost = 0;
                foreach( $sales_for_month as $project ) {
                    $value += $project->costs->sum('value');
                    $cost += $project->costs->sum('cost');
                }
                $month_stats['profit'] = $value - $cost;
                $month_stats['revenue'] = $value - $cost;
                $month_stats['value'] = $value;
                $month_stats['cost'] = $cost;

                $sale_profit = $value - $cost;

                $revenue += $value;
                $profit += $sale_profit;

                $sales[] = [

                    'date'      => $from->copy(),
                    'month'     => $from->format('m'),
                    'value'     => $value,
                    'cost'      => $cost,
                    'profit'    => $sale_profit
                ];


                $rangeProspects = Project::prospects()->whereBetween('created_at', [$from, $to])->external()->with('costs')->get();
                $month_stats['prospectsSum'] = $this->countProjects($rangeProspects);

                $rangeProspects = Project::active()->whereBetween('conversion_date', [$from, $to])->external()->with('costs')->get();
                $month_stats['activeSum'] = $this->countProjects($rangeProspects);

                $rangeProspects = Project::lost()->whereBetween('conversion_date', [$from, $to])->external()->with('costs')->get();
                $month_stats['lostSum'] = $this->countProjects($rangeProspects);

                $rangeProspects = Project::complete()->whereBetween('conversion_date', [$from, $to])->external()->with('costs')->get();
                $month_stats['completedSum'] = $this->countProjects($rangeProspects);

                // $carbon_date = new Carbon();
                // $per_month[$from->toDateString()] = $month_stats;
                $per_month[$from->format('Y-m')] = $month_stats;
                $from->addMonth(1)->startOfMonth();
            }

            $average_conversion_time = Project::whereNotNull('conversion_date')
                ->external()
                ->whereHas('costs', function($q) {
                    $q->where('value', '>', 0);
                })
                ->select('created_at', 'conversion_date', DB::raw('AVG(DATEDIFF(created_at, conversion_date)) as days'))
                ->pluck('days')
                ->first();

            // $average_finish_time = Project::whereNotNull('conversion_date')
            //     ->whereHas('costs', function($q) {
            //         $q->where('value', '>', 0);
            //     })
            //     ->select('created_at', 'conversion_date', DB::raw('AVG(DATEDIFF(created_at, conversion_date)) as days'))
            //     ->pluck('days')
            //     ->first();

            if($converted > 0){
                $average_value = $revenue / $converted;

                // Calculate 5 ways
                $conversion_rate = ($prospects / $converted) * 100;
                $number_of_customers = $prospects * $conversion_rate;
                $turnover = $number_of_customers * $converted * $average_value;
                if($revenue > 0)
                    $profit_margin = ($profit / $revenue);
                else
                    $profit_margin = 0;
            }else{
                $average_value = 0;
                $conversion_rate = 0;
                $number_of_customers = 0;
                $turnover = 0;
                $profit_margin = 0;
            }

            // dump($start_full_date_string);
            // dump($end_full_date_string);
            $rangeProspects = Project::prospects()->external()->whereBetween('created_at', [$start_full_date_string, $end_full_date_string])->with('costs')->get();
            $prospectsSum = $this->countProjects($rangeProspects);

            $rangeProspects = Project::active()->external()->whereBetween('created_at', [$start_full_date_string, $end_full_date_string])->with('costs')->get();
            $activeSum = $this->countProjects($rangeProspects);

            $rangeProspects = Project::lost()->external()->whereBetween('created_at', [$start_full_date_string, $end_full_date_string])->with('costs')->get();
            $lostSum = $this->countProjects($rangeProspects);

            $rangeProspects = Project::complete()->external()->whereBetween('created_at', [$start_full_date_string, $end_full_date_string])->with('costs')->get();
            $completedSum = $this->countProjects($rangeProspects);



        }

        $bills = Bill::unpaid()->get();
        $total_bills = Bill::unpaid()->sum('amount');

        // Go back 3 years
        $date_options = [];
        $months = 36;
        $date = Carbon::now()->endOfMonth();
        for( $i = 0; $i < $months; $i++ ) {
            $date_options[$date->format('Y-m')] = $date->format('F Y');
            $date->subMonth(1);
        }

        return view('finance.index', compact('sales', 'start_date', 'end_date', 'bills', 'total_bills', 'date_options', 'prospects', 'converted', 'revenue', 'profit', 'average_conversion_time', 'average_value', 'conversion_rate', 'number_of_customers', 'turnover', 'profit_margin',
        'prospectsSum', 'activeSum', 'lostSum', 'completedSum', 'check_prospects', 'check_active', 'check_lost', 'check_complete','per_month'
    ));
    }
}
