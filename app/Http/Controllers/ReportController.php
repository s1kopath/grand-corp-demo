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
}
