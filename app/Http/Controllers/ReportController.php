<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DebitNote;
use App\Models\Indent;
use App\Models\LetterOfCredit;
use App\Models\Principal;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $reports = $this->getReportsList();
        $reportStats = $this->getReportStats();

        return view('reports.index', compact('reports', 'reportStats'));
    }

    public function export($slug)
    {
        $report = $this->getReportBySlug($slug);

        if (!$report) {
            abort(404, 'Report not found');
        }

        // Generate sample data for the report
        $data = $this->generateReportData($slug);

        // Return a sample file download
        $filename = $report['filename'];
        $content = $this->generateSampleContent($slug, $data);

        return response($content)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // Detailed Report Methods
    public function paretoAnalysis(Request $request)
    {
        // Get date filters from request
        $fromDate = $request->get('from_date', now()->subYear()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->format('Y-m-d'));

        // Generate data for selected period
        $data = $this->generateParetoAnalysisData($fromDate, $toDate);

        // Generate comparison data for last 2 years
        $comparisonData = $this->generateParetoComparisonData($fromDate, $toDate);

        return view('reports.pareto-analysis', compact('data', 'comparisonData', 'fromDate', 'toDate'));
    }

    public function principalProductVolume(Request $request)
    {
        // Get date filters from request
        $fromDate = $request->get('from_date', now()->subYear()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->format('Y-m-d'));

        // Generate data for selected period
        $data = $this->generatePrincipalProductVolumeData($fromDate, $toDate);

        // Generate comparison data for last 2 years
        $comparisonData = $this->generatePrincipalProductVolumeComparisonData($fromDate, $toDate);

        return view('reports.principal-product-volume', compact('data', 'comparisonData', 'fromDate', 'toDate'));
    }

    public function productPrincipalEngagement(Request $request)
    {
        // Get date filters from request
        $fromDate = $request->get('from_date', now()->subYear()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->format('Y-m-d'));

        // Generate data for selected period
        $data = $this->generateProductPrincipalEngagementData($fromDate, $toDate);

        // Generate comparison data for last 2 years
        $comparisonData = $this->generateProductPrincipalEngagementComparisonData($fromDate, $toDate);

        return view('reports.product-principal-engagement', compact('data', 'comparisonData', 'fromDate', 'toDate'));
    }

    public function indentsVsShipments(Request $request)
    {
        // Get date filters from request
        $fromDate = $request->get('from_date', now()->subYear()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->format('Y-m-d'));

        // Generate data for selected period
        $data = $this->generateIndentsVsShipmentsData($fromDate, $toDate);

        // Generate comparison data for last 2 years
        $comparisonData = $this->generateIndentsVsShipmentsComparisonData($fromDate, $toDate);

        return view('reports.indents-vs-shipments', compact('data', 'comparisonData', 'fromDate', 'toDate'));
    }

    public function customerBusinessVolume(Request $request)
    {
        // Get date filters from request
        $fromDate = $request->get('from_date', now()->subYear()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->format('Y-m-d'));

        // Generate data for selected period
        $data = $this->generateCustomerBusinessVolumeData($fromDate, $toDate);

        // Generate comparison data for last 2 years
        $comparisonData = $this->generateCustomerBusinessVolumeComparisonData($fromDate, $toDate);

        return view('reports.customer-business-volume', compact('data', 'comparisonData', 'fromDate', 'toDate'));
    }

    public function outstandingPayments(Request $request)
    {
        // Get date filters from request
        $fromDate = $request->get('from_date', now()->subYear()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->format('Y-m-d'));

        // Generate data for selected period
        $data = $this->generateOutstandingPaymentsData($fromDate, $toDate);

        // Generate comparison data for last 2 years
        $comparisonData = $this->generateOutstandingPaymentsComparisonData($fromDate, $toDate);

        return view('reports.outstanding-payments', compact('data', 'comparisonData', 'fromDate', 'toDate'));
    }

    public function lcExpiryAnalysis(Request $request)
    {
        // Get date filters from request
        $fromDate = $request->get('from_date', now()->subYear()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->format('Y-m-d'));

        // Generate data for selected period
        $data = $this->generateLcExpiryAnalysisData($fromDate, $toDate);

        // Generate comparison data for last 2 years
        $comparisonData = $this->generateLcExpiryAnalysisComparisonData($fromDate, $toDate);

        return view('reports.lc-expiry-analysis', compact('data', 'comparisonData', 'fromDate', 'toDate'));
    }

    private function getReportsList()
    {
        return [
            [
                'slug' => 'sales-performance',
                'title' => 'Sales Performance Report',
                'description' => 'Monthly sales performance by customer, product, and region',
                'icon' => 'trending_up',
                'color' => 'success',
                'filename' => 'sales_performance_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(2)->format('M d, Y H:i'),
                'records' => 1250
            ],
            [
                'slug' => 'customer-analysis',
                'title' => 'Customer Analysis Report',
                'description' => 'Customer profitability, order history, and business volume',
                'icon' => 'people',
                'color' => 'primary',
                'filename' => 'customer_analysis_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(1)->format('M d, Y H:i'),
                'records' => 89
            ],
            [
                'slug' => 'inventory-status',
                'title' => 'Inventory Status Report',
                'description' => 'Current inventory levels, stock movements, and reorder points',
                'icon' => 'inventory',
                'color' => 'warning',
                'filename' => 'inventory_status_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subHours(6)->format('M d, Y H:i'),
                'records' => 340
            ],
            [
                'slug' => 'financial-summary',
                'title' => 'Financial Summary Report',
                'description' => 'Revenue, receivables, payment status, and financial metrics',
                'icon' => 'account_balance',
                'color' => 'info',
                'filename' => 'financial_summary_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subHours(12)->format('M d, Y H:i'),
                'records' => 567
            ],
            [
                'slug' => 'logistics-performance',
                'title' => 'Logistics Performance Report',
                'description' => 'Shipment tracking, delivery times, and logistics costs',
                'icon' => 'local_shipping',
                'color' => 'secondary',
                'filename' => 'logistics_performance_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(3)->format('M d, Y H:i'),
                'records' => 234
            ],
            [
                'slug' => 'supplier-analysis',
                'title' => 'Supplier Analysis Report',
                'description' => 'Principal performance, product portfolio, and supplier metrics',
                'icon' => 'business',
                'color' => 'dark',
                'filename' => 'supplier_analysis_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(4)->format('M d, Y H:i'),
                'records' => 156
            ],
            [
                'slug' => 'compliance-report',
                'title' => 'Compliance Report',
                'description' => 'Regulatory compliance, certificates, and audit trails',
                'icon' => 'verified',
                'color' => 'success',
                'filename' => 'compliance_report_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(5)->format('M d, Y H:i'),
                'records' => 89
            ],
            [
                'slug' => 'operational-metrics',
                'title' => 'Operational Metrics Report',
                'description' => 'Key performance indicators and operational efficiency metrics',
                'icon' => 'analytics',
                'color' => 'primary',
                'filename' => 'operational_metrics_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(1)->format('M d, Y H:i'),
                'records' => 445
            ]
        ];
    }

    private function getReportStats()
    {
        return [
            'total_reports' => 8,
            'reports_generated_today' => 3,
            'total_records_exported' => 3180,
            'most_popular_report' => 'Sales Performance Report',
            'average_generation_time' => '2.3 minutes'
        ];
    }

    private function getReportBySlug($slug)
    {
        $reports = $this->getReportsList();

        foreach ($reports as $report) {
            if ($report['slug'] === $slug) {
                return $report;
            }
        }

        return null;
    }

    private function generateReportData($slug)
    {
        switch ($slug) {
            case 'sales-performance':
                return [
                    'total_sales' => Quotation::where('status', 'approved')->count(),
                    'total_revenue' => DebitNote::where('status', 'paid')->sum('total_amount'),
                    'top_customers' => Customer::withCount('quotations')->orderBy('quotations_count', 'desc')->limit(5)->get(),
                    'top_products' => Product::withCount('quotationItems')->orderBy('quotation_items_count', 'desc')->limit(5)->get()
                ];

            case 'customer-analysis':
                return [
                    'total_customers' => Customer::count(),
                    'active_customers' => Customer::whereHas('quotations')->count(),
                    'customer_regions' => Customer::select('region', DB::raw('count(*) as count'))->groupBy('region')->get(),
                    'customer_business_volume' => Customer::withSum('debitNotes', 'total_amount')->orderBy('debit_notes_sum_total_amount', 'desc')->limit(10)->get()
                ];

            case 'inventory-status':
                return [
                    'total_products' => Product::count(),
                    'active_products' => Product::where('status', 'active')->count(),
                    'product_categories' => Product::select('category', DB::raw('count(*) as count'))->groupBy('category')->get(),
                    'low_stock_products' => Product::where('stock_quantity', '<', 10)->get()
                ];

            case 'financial-summary':
                return [
                    'total_receivables' => DebitNote::where('status', '!=', 'cancelled')->sum('total_amount'),
                    'paid_receivables' => DebitNote::where('status', 'paid')->sum('total_amount'),
                    'pending_receivables' => DebitNote::where('status', 'pending')->sum('total_amount'),
                    'overdue_amount' => DebitNote::where('status', 'approved')->where('due_date', '<', now())->sum('total_amount')
                ];

            case 'logistics-performance':
                return [
                    'total_shipments' => Shipment::count(),
                    'completed_shipments' => Shipment::where('status', 'delivered')->count(),
                    'in_transit_shipments' => Shipment::where('status', 'in_transit')->count(),
                    'average_delivery_time' => 15.5 // days
                ];

            case 'supplier-analysis':
                return [
                    'total_principals' => Principal::count(),
                    'active_principals' => Principal::where('status', 'active')->count(),
                    'principal_countries' => Principal::select('country', DB::raw('count(*) as count'))->groupBy('country')->get(),
                    'top_principals' => Principal::withCount('products')->orderBy('products_count', 'desc')->limit(5)->get()
                ];

            case 'compliance-report':
                return [
                    'total_certificates' => DB::table('certificates')->count(),
                    'valid_certificates' => DB::table('certificates')->where('status', 'valid')->count(),
                    'expired_certificates' => DB::table('certificates')->where('status', 'expired')->count(),
                    'compliance_score' => 94.5
                ];

            case 'operational-metrics':
                return [
                    'total_quotations' => Quotation::count(),
                    'total_indents' => Indent::count(),
                    'total_lcs' => LetterOfCredit::count(),
                    'conversion_rate' => 78.5 // percentage
                ];

            default:
                return [];
        }
    }

    private function generateSampleContent($slug, $data)
    {
        // Generate a simple CSV-like content for demo purposes
        $content = "Report: " . ucwords(str_replace('-', ' ', $slug)) . "\n";
        $content .= "Generated: " . now()->format('Y-m-d H:i:s') . "\n";
        $content .= "Records: " . ($data['total_sales'] ?? $data['total_customers'] ?? $data['total_products'] ?? 0) . "\n\n";

        // Add some sample data rows
        $content .= "Sample Data:\n";
        $content .= "ID,Name,Value,Status\n";
        $content .= "1,Sample Record 1,1000.00,Active\n";
        $content .= "2,Sample Record 2,2500.00,Active\n";
        $content .= "3,Sample Record 3,1800.00,Pending\n";
        $content .= "4,Sample Record 4,3200.00,Completed\n";
        $content .= "5,Sample Record 5,950.00,Active\n";

        return $content;
    }

    // Data Generation Methods for Detailed Reports
    private function generateParetoAnalysisData($fromDate = null, $toDate = null)
    {
        // Demo data for Pareto analysis with realistic customer revenue data
        $demoCustomers = [
            [
                'name' => 'Dhaka Medical College Hospital',
                'base_revenue' => 1250000,
                'growth_factor' => 1.15
            ],
            [
                'name' => 'Square Hospital',
                'base_revenue' => 980000,
                'growth_factor' => 1.12
            ],
            [
                'name' => 'Apollo Hospitals',
                'base_revenue' => 1560000,
                'growth_factor' => 1.18
            ],
            [
                'name' => 'United Hospital',
                'base_revenue' => 870000,
                'growth_factor' => 1.10
            ],
            [
                'name' => 'Popular Medical Centre',
                'base_revenue' => 1340000,
                'growth_factor' => 1.16
            ],
            [
                'name' => 'Labaid Hospital',
                'base_revenue' => 1120000,
                'growth_factor' => 1.13
            ],
            [
                'name' => 'Apex Pharmacy',
                'base_revenue' => 890000,
                'growth_factor' => 1.11
            ],
            [
                'name' => 'MedPlus Pharmacy',
                'base_revenue' => 760000,
                'growth_factor' => 1.09
            ],
            [
                'name' => 'Popular Diagnostic Centre',
                'base_revenue' => 1450000,
                'growth_factor' => 1.19
            ],
            [
                'name' => 'LabAid Diagnostic',
                'base_revenue' => 1030000,
                'growth_factor' => 1.14
            ]
        ];

        // Calculate revenue based on date range (simulate growth over time)
        $currentYear = $fromDate ? date('Y', strtotime($fromDate)) : date('Y');
        $baseYear = 2022; // Base year for calculations
        $yearDifference = $currentYear - $baseYear;

        $customersWithRevenue = collect($demoCustomers)->map(function ($customer) use ($yearDifference) {
            $adjustedRevenue = $customer['base_revenue'] * pow($customer['growth_factor'], $yearDifference);
            // Add some random variation (±10%)
            $variation = 1 + (rand(-10, 10) / 100);
            $finalRevenue = $adjustedRevenue * $variation;

            return [
                'name' => $customer['name'],
                'total_value' => round($finalRevenue, 2)
            ];
        })->sortByDesc('total_value')->values();

        $totalRevenue = $customersWithRevenue->sum('total_value');
        $cumulativePercentage = 0;

        $paretoData = $customersWithRevenue->map(function ($customer, $index) use ($totalRevenue, &$cumulativePercentage) {
            $percentage = $totalRevenue > 0 ? ($customer['total_value'] / $totalRevenue) * 100 : 0;
            $cumulativePercentage += $percentage;

            return [
                'rank' => $index + 1,
                'name' => $customer['name'],
                'total_value' => $customer['total_value'],
                'percentage' => round($percentage, 2),
                'cumulative_percentage' => round($cumulativePercentage, 2)
            ];
        });

        return [
            'pareto_data' => $paretoData,
            'total_revenue' => $totalRevenue,
            'report_date' => now()->format('M d, Y'),
            'currency' => 'BDT',
            'period' => [
                'from' => $fromDate ? date('M d, Y', strtotime($fromDate)) : 'All Time',
                'to' => $toDate ? date('M d, Y', strtotime($toDate)) : 'Present'
            ]
        ];
    }

    private function generateParetoComparisonData($fromDate, $toDate)
    {
        // Generate comparison data for last 2 years
        $currentYear = date('Y', strtotime($fromDate));
        $previousYear = $currentYear - 1;
        $twoYearsAgo = $currentYear - 2;

        // Current period data (already generated in main method)
        $currentPeriodData = $this->generateParetoAnalysisData($fromDate, $toDate);

        // Previous year data (same period)
        $prevYearFromDate = date('Y-m-d', strtotime($fromDate . ' -1 year'));
        $prevYearToDate = date('Y-m-d', strtotime($toDate . ' -1 year'));
        $previousYearData = $this->generateParetoAnalysisData($prevYearFromDate, $prevYearToDate);

        // Two years ago data (same period)
        $twoYearsAgoFromDate = date('Y-m-d', strtotime($fromDate . ' -2 years'));
        $twoYearsAgoToDate = date('Y-m-d', strtotime($toDate . ' -2 years'));
        $twoYearsAgoData = $this->generateParetoAnalysisData($twoYearsAgoFromDate, $twoYearsAgoToDate);

        return [
            'current_year' => [
                'year' => $currentYear,
                'data' => $currentPeriodData,
                'period' => $currentPeriodData['period']
            ],
            'previous_year' => [
                'year' => $previousYear,
                'data' => $previousYearData,
                'period' => $previousYearData['period']
            ],
            'two_years_ago' => [
                'year' => $twoYearsAgo,
                'data' => $twoYearsAgoData,
                'period' => $twoYearsAgoData['period']
            ]
        ];
    }

    private function generatePrincipalProductVolumeData($fromDate = null, $toDate = null)
    {
        // Principal-wise product volume analysis - Demo Data with growth factors
        $demoPrincipals = [
            [
                'principal_name' => 'Pfizer Inc',
                'base_product_count' => 15,
                'base_indent_volume' => 25000,
                'base_shipment_volume' => 22000,
                'base_on_time_percentage' => 94.5,
                'growth_factor' => 1.12
            ],
            [
                'principal_name' => 'Novartis AG',
                'base_product_count' => 12,
                'base_indent_volume' => 22000,
                'base_shipment_volume' => 19500,
                'base_on_time_percentage' => 91.2,
                'growth_factor' => 1.15
            ],
            [
                'principal_name' => 'Johnson & Johnson',
                'base_product_count' => 18,
                'base_indent_volume' => 28000,
                'base_shipment_volume' => 26500,
                'base_on_time_percentage' => 96.8,
                'growth_factor' => 1.18
            ],
            [
                'principal_name' => 'Roche Holding AG',
                'base_product_count' => 10,
                'base_indent_volume' => 18000,
                'base_shipment_volume' => 16500,
                'base_on_time_percentage' => 89.3,
                'growth_factor' => 1.10
            ],
            [
                'principal_name' => 'Merck & Co',
                'base_product_count' => 14,
                'base_indent_volume' => 21000,
                'base_shipment_volume' => 19000,
                'base_on_time_percentage' => 92.7,
                'growth_factor' => 1.13
            ],
            [
                'principal_name' => 'Sun Pharmaceutical',
                'base_product_count' => 20,
                'base_indent_volume' => 32000,
                'base_shipment_volume' => 29500,
                'base_on_time_percentage' => 88.9,
                'growth_factor' => 1.16
            ],
            [
                'principal_name' => 'Dr. Reddy\'s Laboratories',
                'base_product_count' => 16,
                'base_indent_volume' => 24000,
                'base_shipment_volume' => 21500,
                'base_on_time_percentage' => 93.1,
                'growth_factor' => 1.14
            ],
            [
                'principal_name' => 'Cipla Ltd',
                'base_product_count' => 13,
                'base_indent_volume' => 19000,
                'base_shipment_volume' => 17500,
                'base_on_time_percentage' => 90.5,
                'growth_factor' => 1.11
            ]
        ];

        // Calculate data based on date range (simulate growth over time)
        $currentYear = $fromDate ? date('Y', strtotime($fromDate)) : date('Y');
        $baseYear = 2022; // Base year for calculations
        $yearDifference = $currentYear - $baseYear;

        $principalsWithData = collect($demoPrincipals)->map(function ($principal) use ($yearDifference) {
            $growthMultiplier = pow($principal['growth_factor'], $yearDifference);
            $variation = 1 + (rand(-8, 8) / 100); // ±8% variation

            $adjustedIndentVolume = round($principal['base_indent_volume'] * $growthMultiplier * $variation);
            $adjustedShipmentVolume = round($adjustedIndentVolume * 0.92); // 92% of indent volume
            $adjustedOnTimePercentage = min(100, $principal['base_on_time_percentage'] + (rand(-3, 3))); // ±3% variation
            $adjustedProductCount = round($principal['base_product_count'] * (1 + ($yearDifference * 0.1))); // 10% growth per year

            return [
                'principal_name' => $principal['principal_name'],
                'product_count' => $adjustedProductCount,
                'total_indent_volume' => $adjustedIndentVolume,
                'total_shipment_volume' => $adjustedShipmentVolume,
                'shipped_on_time_percentage' => round($adjustedOnTimePercentage, 1)
            ];
        })->sortByDesc('total_indent_volume')->values();

        return [
            'principals' => $principalsWithData,
            'report_date' => now()->format('M d, Y'),
            'total_principals' => count($principalsWithData),
            'period' => [
                'from' => $fromDate ? date('M d, Y', strtotime($fromDate)) : 'All Time',
                'to' => $toDate ? date('M d, Y', strtotime($toDate)) : 'Present'
            ]
        ];
    }

    private function generatePrincipalProductVolumeComparisonData($fromDate, $toDate)
    {
        // Generate comparison data for last 2 years
        $currentYear = date('Y', strtotime($fromDate));
        $previousYear = $currentYear - 1;
        $twoYearsAgo = $currentYear - 2;

        // Current period data (already generated in main method)
        $currentPeriodData = $this->generatePrincipalProductVolumeData($fromDate, $toDate);

        // Previous year data (same period)
        $prevYearFromDate = date('Y-m-d', strtotime($fromDate . ' -1 year'));
        $prevYearToDate = date('Y-m-d', strtotime($toDate . ' -1 year'));
        $previousYearData = $this->generatePrincipalProductVolumeData($prevYearFromDate, $prevYearToDate);

        // Two years ago data (same period)
        $twoYearsAgoFromDate = date('Y-m-d', strtotime($fromDate . ' -2 years'));
        $twoYearsAgoToDate = date('Y-m-d', strtotime($toDate . ' -2 years'));
        $twoYearsAgoData = $this->generatePrincipalProductVolumeData($twoYearsAgoFromDate, $twoYearsAgoToDate);

        return [
            'current_year' => [
                'year' => $currentYear,
                'data' => $currentPeriodData,
                'period' => $currentPeriodData['period']
            ],
            'previous_year' => [
                'year' => $previousYear,
                'data' => $previousYearData,
                'period' => $previousYearData['period']
            ],
            'two_years_ago' => [
                'year' => $twoYearsAgo,
                'data' => $twoYearsAgoData,
                'period' => $twoYearsAgoData['period']
            ]
        ];
    }

    private function generateProductPrincipalEngagementData($fromDate = null, $toDate = null)
    {
        // Product-wise principal engagement - Demo Data with growth factors
        $demoProducts = [
            [
                'product_name' => 'Amoxicillin 500mg',
                'principal' => 'Pfizer Inc',
                'base_orders' => 45,
                'base_delay' => 2,
                'base_outstanding' => 3,
                'growth_factor' => 1.12
            ],
            [
                'product_name' => 'Paracetamol 500mg',
                'principal' => 'Novartis AG',
                'base_orders' => 38,
                'base_delay' => 1,
                'base_outstanding' => 1,
                'growth_factor' => 1.15
            ],
            [
                'product_name' => 'Metformin 500mg',
                'principal' => 'Johnson & Johnson',
                'base_orders' => 42,
                'base_delay' => 3,
                'base_outstanding' => 5,
                'growth_factor' => 1.18
            ],
            [
                'product_name' => 'Amlodipine 5mg',
                'principal' => 'Roche Holding AG',
                'base_orders' => 35,
                'base_delay' => 2,
                'base_outstanding' => 2,
                'growth_factor' => 1.10
            ],
            [
                'product_name' => 'Insulin Regular',
                'principal' => 'Merck & Co',
                'base_orders' => 28,
                'base_delay' => 4,
                'base_outstanding' => 7,
                'growth_factor' => 1.13
            ],
            [
                'product_name' => 'COVID-19 Vaccine',
                'principal' => 'Sun Pharmaceutical',
                'base_orders' => 52,
                'base_delay' => 1,
                'base_outstanding' => 0,
                'growth_factor' => 1.16
            ],
            [
                'product_name' => 'Stethoscope',
                'principal' => 'Dr. Reddy\'s Laboratories',
                'base_orders' => 31,
                'base_delay' => 2,
                'base_outstanding' => 4,
                'growth_factor' => 1.14
            ],
            [
                'product_name' => 'Blood Pressure Monitor',
                'principal' => 'Cipla Ltd',
                'base_orders' => 25,
                'base_delay' => 3,
                'base_outstanding' => 6,
                'growth_factor' => 1.11
            ],
            [
                'product_name' => 'Surgical Mask',
                'principal' => 'Pfizer Inc',
                'base_orders' => 48,
                'base_delay' => 1,
                'base_outstanding' => 2,
                'growth_factor' => 1.12
            ],
            [
                'product_name' => 'COVID-19 Test Kit',
                'principal' => 'Novartis AG',
                'base_orders' => 55,
                'base_delay' => 2,
                'base_outstanding' => 1,
                'growth_factor' => 1.15
            ],
            [
                'product_name' => 'Ciprofloxacin 250mg',
                'principal' => 'Johnson & Johnson',
                'base_orders' => 33,
                'base_delay' => 2,
                'base_outstanding' => 3,
                'growth_factor' => 1.18
            ],
            [
                'product_name' => 'Ibuprofen 400mg',
                'principal' => 'Roche Holding AG',
                'base_orders' => 29,
                'base_delay' => 1,
                'base_outstanding' => 1,
                'growth_factor' => 1.10
            ],
            [
                'product_name' => 'Thermometer Digital',
                'principal' => 'Merck & Co',
                'base_orders' => 22,
                'base_delay' => 3,
                'base_outstanding' => 5,
                'growth_factor' => 1.13
            ],
            [
                'product_name' => 'Surgical Gloves',
                'principal' => 'Sun Pharmaceutical',
                'base_orders' => 41,
                'base_delay' => 2,
                'base_outstanding' => 4,
                'growth_factor' => 1.16
            ],
            [
                'product_name' => 'Pregnancy Test Kit',
                'principal' => 'Dr. Reddy\'s Laboratories',
                'base_orders' => 27,
                'base_delay' => 2,
                'base_outstanding' => 3,
                'growth_factor' => 1.14
            ]
        ];

        // Calculate data based on date range (simulate growth over time)
        $currentYear = $fromDate ? date('Y', strtotime($fromDate)) : date('Y');
        $baseYear = 2022; // Base year for calculations
        $yearDifference = $currentYear - $baseYear;

        $productsWithData = collect($demoProducts)->map(function ($product) use ($yearDifference) {
            $growthMultiplier = pow($product['growth_factor'], $yearDifference);
            $variation = 1 + (rand(-10, 10) / 100); // ±10% variation

            $adjustedOrders = round($product['base_orders'] * $growthMultiplier * $variation);
            $adjustedDelay = max(0, $product['base_delay'] + (rand(-1, 1))); // ±1 day variation
            $adjustedOutstanding = max(0, round($product['base_outstanding'] * (1 + (rand(-20, 20) / 100)))); // ±20% variation

            return [
                'product_name' => $product['product_name'],
                'principal' => $product['principal'],
                'total_orders' => $adjustedOrders,
                'avg_shipment_delay' => $adjustedDelay,
                'outstanding_indent' => $adjustedOutstanding
            ];
        })->sortByDesc('total_orders')->values();

        return [
            'products' => $productsWithData,
            'report_date' => now()->format('M d, Y'),
            'total_products' => count($productsWithData),
            'period' => [
                'from' => $fromDate ? date('M d, Y', strtotime($fromDate)) : 'All Time',
                'to' => $toDate ? date('M d, Y', strtotime($toDate)) : 'Present'
            ]
        ];
    }

    private function generateProductPrincipalEngagementComparisonData($fromDate, $toDate)
    {
        // Generate comparison data for last 2 years
        $currentYear = date('Y', strtotime($fromDate));
        $previousYear = $currentYear - 1;
        $twoYearsAgo = $currentYear - 2;

        // Current period data (already generated in main method)
        $currentPeriodData = $this->generateProductPrincipalEngagementData($fromDate, $toDate);

        // Previous year data (same period)
        $prevYearFromDate = date('Y-m-d', strtotime($fromDate . ' -1 year'));
        $prevYearToDate = date('Y-m-d', strtotime($toDate . ' -1 year'));
        $previousYearData = $this->generateProductPrincipalEngagementData($prevYearFromDate, $prevYearToDate);

        // Two years ago data (same period)
        $twoYearsAgoFromDate = date('Y-m-d', strtotime($fromDate . ' -2 years'));
        $twoYearsAgoToDate = date('Y-m-d', strtotime($toDate . ' -2 years'));
        $twoYearsAgoData = $this->generateProductPrincipalEngagementData($twoYearsAgoFromDate, $twoYearsAgoToDate);

        return [
            'current_year' => [
                'year' => $currentYear,
                'data' => $currentPeriodData,
                'period' => $currentPeriodData['period']
            ],
            'previous_year' => [
                'year' => $previousYear,
                'data' => $previousYearData,
                'period' => $previousYearData['period']
            ],
            'two_years_ago' => [
                'year' => $twoYearsAgo,
                'data' => $twoYearsAgoData,
                'period' => $twoYearsAgoData['period']
            ]
        ];
    }

    private function generateIndentsVsShipmentsData($fromDate = null, $toDate = null)
    {
        // Monthly indents vs shipments analysis
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('F');

            $totalIndents = rand(100, 150);
            $shippedOnTime = rand(85, 95);
            $delayedShipments = $totalIndents - $shippedOnTime;
            $onTimePercentage = $totalIndents > 0 ? ($shippedOnTime / $totalIndents) * 100 : 0;

            $months->push([
                'month' => $monthName,
                'total_indents' => $totalIndents,
                'shipped_on_time' => $shippedOnTime,
                'delayed_shipments' => $delayedShipments,
                'on_time_percentage' => round($onTimePercentage, 1)
            ]);
        }

        return [
            'monthly_data' => $months,
            'report_date' => now()->format('M d, Y'),
            'total_months' => $months->count(),
            'period' => [
                'from' => $fromDate ? date('M d, Y', strtotime($fromDate)) : 'All Time',
                'to' => $toDate ? date('M d, Y', strtotime($toDate)) : 'Present'
            ]
        ];
    }

    private function generateCustomerBusinessVolumeData($fromDate = null, $toDate = null)
    {
        // Customer-wise business volume - Demo Data
        $customers = [
            [
                'customer_name' => 'Dhaka Medical College Hospital',
                'total_orders' => 125,
                'total_volume' => 8500,
                'total_revenue' => 1250000,
                'avg_lead_time' => 8
            ],
            [
                'customer_name' => 'Square Hospital',
                'total_orders' => 98,
                'total_volume' => 7200,
                'total_revenue' => 980000,
                'avg_lead_time' => 6
            ],
            [
                'customer_name' => 'Apollo Hospitals',
                'total_orders' => 156,
                'total_volume' => 11200,
                'total_revenue' => 1560000,
                'avg_lead_time' => 10
            ],
            [
                'customer_name' => 'United Hospital',
                'total_orders' => 87,
                'total_volume' => 6500,
                'total_revenue' => 870000,
                'avg_lead_time' => 7
            ],
            [
                'customer_name' => 'Popular Medical Centre',
                'total_orders' => 134,
                'total_volume' => 9200,
                'total_revenue' => 1340000,
                'avg_lead_time' => 9
            ],
            [
                'customer_name' => 'Labaid Hospital',
                'total_orders' => 112,
                'total_volume' => 7800,
                'total_revenue' => 1120000,
                'avg_lead_time' => 8
            ],
            [
                'customer_name' => 'Apex Pharmacy',
                'total_orders' => 89,
                'total_volume' => 6800,
                'total_revenue' => 890000,
                'avg_lead_time' => 5
            ],
            [
                'customer_name' => 'MedPlus Pharmacy',
                'total_orders' => 76,
                'total_volume' => 5400,
                'total_revenue' => 760000,
                'avg_lead_time' => 6
            ],
            [
                'customer_name' => 'Popular Diagnostic Centre',
                'total_orders' => 145,
                'total_volume' => 9800,
                'total_revenue' => 1450000,
                'avg_lead_time' => 11
            ],
            [
                'customer_name' => 'LabAid Diagnostic',
                'total_orders' => 103,
                'total_volume' => 7500,
                'total_revenue' => 1030000,
                'avg_lead_time' => 9
            ]
        ];

        return [
            'customers' => collect($customers)->sortByDesc('total_revenue'),
            'report_date' => now()->format('M d, Y'),
            'currency' => 'BDT',
            'total_customers' => count($customers),
            'period' => [
                'from' => $fromDate ? date('M d, Y', strtotime($fromDate)) : 'All Time',
                'to' => $toDate ? date('M d, Y', strtotime($toDate)) : 'Present'
            ]
        ];
    }

    private function generateOutstandingPaymentsData($fromDate = null, $toDate = null)
    {
        // Outstanding payments by customer - Demo Data
        $customers = [
            [
                'customer_name' => 'Dhaka Medical College Hospital',
                'total_amount_billed' => 1250000,
                'amount_paid' => 1000000,
                'outstanding_amount' => 250000,
                'days_overdue' => 15
            ],
            [
                'customer_name' => 'Square Hospital',
                'total_amount_billed' => 980000,
                'amount_paid' => 850000,
                'outstanding_amount' => 130000,
                'days_overdue' => 8
            ],
            [
                'customer_name' => 'Apollo Hospitals',
                'total_amount_billed' => 1560000,
                'amount_paid' => 1200000,
                'outstanding_amount' => 360000,
                'days_overdue' => 22
            ],
            [
                'customer_name' => 'United Hospital',
                'total_amount_billed' => 870000,
                'amount_paid' => 750000,
                'outstanding_amount' => 120000,
                'days_overdue' => 12
            ],
            [
                'customer_name' => 'Popular Medical Centre',
                'total_amount_billed' => 1340000,
                'amount_paid' => 1100000,
                'outstanding_amount' => 240000,
                'days_overdue' => 18
            ],
            [
                'customer_name' => 'Labaid Hospital',
                'total_amount_billed' => 1120000,
                'amount_paid' => 950000,
                'outstanding_amount' => 170000,
                'days_overdue' => 10
            ],
            [
                'customer_name' => 'Apex Pharmacy',
                'total_amount_billed' => 890000,
                'amount_paid' => 800000,
                'outstanding_amount' => 90000,
                'days_overdue' => 5
            ],
            [
                'customer_name' => 'MedPlus Pharmacy',
                'total_amount_billed' => 760000,
                'amount_paid' => 650000,
                'outstanding_amount' => 110000,
                'days_overdue' => 14
            ],
            [
                'customer_name' => 'Popular Diagnostic Centre',
                'total_amount_billed' => 1450000,
                'amount_paid' => 1150000,
                'outstanding_amount' => 300000,
                'days_overdue' => 25
            ],
            [
                'customer_name' => 'LabAid Diagnostic',
                'total_amount_billed' => 1030000,
                'amount_paid' => 900000,
                'outstanding_amount' => 130000,
                'days_overdue' => 9
            ]
        ];

        return [
            'customers' => collect($customers)->sortByDesc('outstanding_amount'),
            'report_date' => now()->format('M d, Y'),
            'currency' => 'BDT',
            'total_outstanding' => collect($customers)->sum('outstanding_amount'),
            'period' => [
                'from' => $fromDate ? date('M d, Y', strtotime($fromDate)) : 'All Time',
                'to' => $toDate ? date('M d, Y', strtotime($toDate)) : 'Present'
            ]
        ];
    }

    private function generateLcExpiryAnalysisData($fromDate = null, $toDate = null)
    {
        // L/C expiry analysis - Demo Data
        $lcs = [
            [
                'lc_number' => 'LC-00001',
                'customer' => 'Dhaka Medical College Hospital',
                'principal' => 'Pfizer Inc',
                'amount' => 500000,
                'issue_date' => '15-Jan-24',
                'expiry_date' => '15-Mar-25',
                'days_remaining' => 45,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00002',
                'customer' => 'Square Hospital',
                'principal' => 'Novartis AG',
                'amount' => 750000,
                'issue_date' => '20-Feb-24',
                'expiry_date' => '20-Apr-25',
                'days_remaining' => 81,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00003',
                'customer' => 'Apollo Hospitals',
                'principal' => 'Johnson & Johnson',
                'amount' => 1200000,
                'issue_date' => '10-Mar-24',
                'expiry_date' => '10-Jun-25',
                'days_remaining' => 132,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00004',
                'customer' => 'United Hospital',
                'principal' => 'Roche Holding AG',
                'amount' => 850000,
                'issue_date' => '05-Apr-24',
                'expiry_date' => '05-Jul-25',
                'days_remaining' => 158,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00005',
                'customer' => 'Popular Medical Centre',
                'principal' => 'Merck & Co',
                'amount' => 650000,
                'issue_date' => '15-May-24',
                'expiry_date' => '15-Aug-25',
                'days_remaining' => 200,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00006',
                'customer' => 'Labaid Hospital',
                'principal' => 'Sun Pharmaceutical',
                'amount' => 950000,
                'issue_date' => '25-Jun-24',
                'expiry_date' => '25-Sep-25',
                'days_remaining' => 242,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00007',
                'customer' => 'Apex Pharmacy',
                'principal' => 'Dr. Reddy\'s Laboratories',
                'amount' => 450000,
                'issue_date' => '10-Jul-24',
                'expiry_date' => '10-Oct-25',
                'days_remaining' => 258,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00008',
                'customer' => 'MedPlus Pharmacy',
                'principal' => 'Cipla Ltd',
                'amount' => 380000,
                'issue_date' => '20-Aug-24',
                'expiry_date' => '20-Nov-25',
                'days_remaining' => 299,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00009',
                'customer' => 'Popular Diagnostic Centre',
                'principal' => 'Pfizer Inc',
                'amount' => 1100000,
                'issue_date' => '05-Sep-24',
                'expiry_date' => '05-Dec-25',
                'days_remaining' => 315,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00010',
                'customer' => 'LabAid Diagnostic',
                'principal' => 'Novartis AG',
                'amount' => 720000,
                'issue_date' => '15-Oct-24',
                'expiry_date' => '15-Jan-26',
                'days_remaining' => 356,
                'status' => 'Active'
            ]
        ];

        return [
            'lcs' => collect($lcs)->sortBy('days_remaining'),
            'report_date' => now()->format('M d, Y'),
            'currency' => 'BDT',
            'total_lcs' => count($lcs),
            'active_lcs' => count($lcs),
            'expired_lcs' => 0,
            'period' => [
                'from' => $fromDate ? date('M d, Y', strtotime($fromDate)) : 'All Time',
                'to' => $toDate ? date('M d, Y', strtotime($toDate)) : 'Present'
            ]
        ];
    }

    // Comparison Methods for all reports
    private function generateCustomerBusinessVolumeComparisonData($fromDate, $toDate)
    {
        // Generate comparison data for last 2 years
        $currentYear = date('Y', strtotime($fromDate));
        $previousYear = $currentYear - 1;
        $twoYearsAgo = $currentYear - 2;

        // Current period data (already generated in main method)
        $currentPeriodData = $this->generateCustomerBusinessVolumeData($fromDate, $toDate);

        // Previous year data (same period)
        $prevYearFromDate = date('Y-m-d', strtotime($fromDate . ' -1 year'));
        $prevYearToDate = date('Y-m-d', strtotime($toDate . ' -1 year'));
        $previousYearData = $this->generateCustomerBusinessVolumeData($prevYearFromDate, $prevYearToDate);

        // Two years ago data (same period)
        $twoYearsAgoFromDate = date('Y-m-d', strtotime($fromDate . ' -2 years'));
        $twoYearsAgoToDate = date('Y-m-d', strtotime($toDate . ' -2 years'));
        $twoYearsAgoData = $this->generateCustomerBusinessVolumeData($twoYearsAgoFromDate, $twoYearsAgoToDate);

        return [
            'current_year' => [
                'year' => $currentYear,
                'data' => $currentPeriodData,
                'period' => $currentPeriodData['period']
            ],
            'previous_year' => [
                'year' => $previousYear,
                'data' => $previousYearData,
                'period' => $previousYearData['period']
            ],
            'two_years_ago' => [
                'year' => $twoYearsAgo,
                'data' => $twoYearsAgoData,
                'period' => $twoYearsAgoData['period']
            ]
        ];
    }

    private function generateOutstandingPaymentsComparisonData($fromDate, $toDate)
    {
        // Generate comparison data for last 2 years
        $currentYear = date('Y', strtotime($fromDate));
        $previousYear = $currentYear - 1;
        $twoYearsAgo = $currentYear - 2;

        // Current period data (already generated in main method)
        $currentPeriodData = $this->generateOutstandingPaymentsData($fromDate, $toDate);

        // Previous year data (same period)
        $prevYearFromDate = date('Y-m-d', strtotime($fromDate . ' -1 year'));
        $prevYearToDate = date('Y-m-d', strtotime($toDate . ' -1 year'));
        $previousYearData = $this->generateOutstandingPaymentsData($prevYearFromDate, $prevYearToDate);

        // Two years ago data (same period)
        $twoYearsAgoFromDate = date('Y-m-d', strtotime($fromDate . ' -2 years'));
        $twoYearsAgoToDate = date('Y-m-d', strtotime($toDate . ' -2 years'));
        $twoYearsAgoData = $this->generateOutstandingPaymentsData($twoYearsAgoFromDate, $twoYearsAgoToDate);

        return [
            'current_year' => [
                'year' => $currentYear,
                'data' => $currentPeriodData,
                'period' => $currentPeriodData['period']
            ],
            'previous_year' => [
                'year' => $previousYear,
                'data' => $previousYearData,
                'period' => $previousYearData['period']
            ],
            'two_years_ago' => [
                'year' => $twoYearsAgo,
                'data' => $twoYearsAgoData,
                'period' => $twoYearsAgoData['period']
            ]
        ];
    }

    private function generateLcExpiryAnalysisComparisonData($fromDate, $toDate)
    {
        // Generate comparison data for last 2 years
        $currentYear = date('Y', strtotime($fromDate));
        $previousYear = $currentYear - 1;
        $twoYearsAgo = $currentYear - 2;

        // Current period data (already generated in main method)
        $currentPeriodData = $this->generateLcExpiryAnalysisData($fromDate, $toDate);

        // Previous year data (same period)
        $prevYearFromDate = date('Y-m-d', strtotime($fromDate . ' -1 year'));
        $prevYearToDate = date('Y-m-d', strtotime($toDate . ' -1 year'));
        $previousYearData = $this->generateLcExpiryAnalysisData($prevYearFromDate, $prevYearToDate);

        // Two years ago data (same period)
        $twoYearsAgoFromDate = date('Y-m-d', strtotime($fromDate . ' -2 years'));
        $twoYearsAgoToDate = date('Y-m-d', strtotime($toDate . ' -2 years'));
        $twoYearsAgoData = $this->generateLcExpiryAnalysisData($twoYearsAgoFromDate, $twoYearsAgoToDate);

        return [
            'current_year' => [
                'year' => $currentYear,
                'data' => $currentPeriodData,
                'period' => $currentPeriodData['period']
            ],
            'previous_year' => [
                'year' => $previousYear,
                'data' => $previousYearData,
                'period' => $previousYearData['period']
            ],
            'two_years_ago' => [
                'year' => $twoYearsAgo,
                'data' => $twoYearsAgoData,
                'period' => $twoYearsAgoData['period']
            ]
        ];
    }

    private function generateIndentsVsShipmentsComparisonData($fromDate, $toDate)
    {
        // Generate comparison data for last 2 years
        $currentYear = date('Y', strtotime($fromDate));
        $previousYear = $currentYear - 1;
        $twoYearsAgo = $currentYear - 2;

        // Current period data (already generated in main method)
        $currentPeriodData = $this->generateIndentsVsShipmentsData($fromDate, $toDate);

        // Previous year data (same period)
        $prevYearFromDate = date('Y-m-d', strtotime($fromDate . ' -1 year'));
        $prevYearToDate = date('Y-m-d', strtotime($toDate . ' -1 year'));
        $previousYearData = $this->generateIndentsVsShipmentsData($prevYearFromDate, $prevYearToDate);

        // Two years ago data (same period)
        $twoYearsAgoFromDate = date('Y-m-d', strtotime($fromDate . ' -2 years'));
        $twoYearsAgoToDate = date('Y-m-d', strtotime($toDate . ' -2 years'));
        $twoYearsAgoData = $this->generateIndentsVsShipmentsData($twoYearsAgoFromDate, $twoYearsAgoToDate);

        return [
            'current_year' => [
                'year' => $currentYear,
                'data' => $currentPeriodData,
                'period' => $currentPeriodData['period']
            ],
            'previous_year' => [
                'year' => $previousYear,
                'data' => $previousYearData,
                'period' => $previousYearData['period']
            ],
            'two_years_ago' => [
                'year' => $twoYearsAgo,
                'data' => $twoYearsAgoData,
                'period' => $twoYearsAgoData['period']
            ]
        ];
    }
}
