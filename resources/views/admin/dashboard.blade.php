@extends('admin.layouts.app', ['title' => 'Healthcare Dashboard'])

@php
    $kpi = $stats['kpi'];
    $byType = collect($stats['byType']);
    $trend = $stats['trend'];
    $people = $stats['people'];
@endphp

@push('style')
    <style>
        .dash-card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
            transition: all 0.2s ease;
            background: #ffffff;
        }

        .dash-kpi {
            display: block;
            color: inherit;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .dash-kpi:hover {
            color: inherit;
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .08);
        }

        .dash-kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dash-kpi-value {
            font-size: 1.85rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .badge-pending {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .badge-reviewed {
            background-color: #fef3c7;
            color: #d97706;
            border: 1px solid #fde68a;
        }

        .badge-contacted {
            background-color: #d1fae5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .dash-quick-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 14px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.88rem;
            transition: all 0.18s ease;
        }

        .dash-quick-link:hover {
            background: #081C36;
            color: #ffffff;
            border-color: #081C36;
            transform: translateX(3px);
        }

        .dash-quick-link:hover i.action-arrow {
            transform: translateX(4px);
            color: #19b5a5 !important;
        }

        .dash-chart {
            position: relative;
            height: 250px;
        }
    </style>
@endpush

@section('panel')

    {{-- WELCOME BANNER --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="dash-card p-4 position-relative overflow-hidden" style="background: radial-gradient(800px 300px at 90% 0%, rgba(25, 181, 165, 0.15), transparent 70%), #081C36; color: #ffffff;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge rounded-pill px-3 py-1 bg-white bg-opacity-10 text-white border border-white border-opacity-20" style="font-size: 0.76rem; letter-spacing: 0.05em;">
                                <i class="bi bi-shield-check text-success me-1"></i> {{ __('3S MEDI CARE DIGITAL HUB') }}
                            </span>
                            <span class="badge bg-success rounded-pill px-2 py-1" style="font-size: 0.72rem;">{{ __('System Online') }}</span>
                        </div>
                        <h3 class="fw-bold text-white mb-1">
                            {{ __('Welcome,') }} {{ auth('admin')->user()->name }}
                        </h3>
                        <p class="text-white text-opacity-75 small mb-0">
                            {{ __('Overview of your healthcare client quote requests, website content, and digital inquiries.') }}
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 shadow-sm">
                            <i class="bi bi-box-arrow-up-right"></i> {{ __('View Public Website') }}
                        </a>
                        <a href="{{ route('admin.quote_request.index') }}" class="btn btn-sm rounded-pill px-3 py-2 text-white fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" style="background: #19b5a5;">
                            <i class="bi bi-inbox-fill"></i> {{ __('All Quotes') }} ({{ $quoteCounts['total'] }})
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4 KPI METRIC CARDS --}}
    <div class="row g-3 mb-4">
        {{-- CARD 1: PENDING QUOTES --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('admin.quote_request.index') }}?status=pending" class="dash-card dash-kpi text-decoration-none h-100 p-3">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dash-kpi-icon" style="background: #fee2e2; color: #dc2626;">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">{{ __('Pending Quotes') }}</span>
                        <div class="dash-kpi-value text-dark">{{ $quoteCounts['pending'] }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <small class="{{ $quoteCounts['pending'] > 0 ? 'text-danger fw-semibold' : 'text-muted' }}">
                        <i class="bi {{ $quoteCounts['pending'] > 0 ? 'bi-exclamation-circle' : 'bi-check2' }} me-1"></i>
                        {{ $quoteCounts['pending'] > 0 ? __('Needs response') : __('All responded') }}
                    </small>
                    <span class="small text-primary fw-medium">{{ __('View list') }} &rarr;</span>
                </div>
            </a>
        </div>

        {{-- CARD 2: TOTAL QUOTES --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('admin.quote_request.index') }}" class="dash-card dash-kpi text-decoration-none h-100 p-3">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dash-kpi-icon" style="background: #e0f2fe; color: #0284c7;">
                        <i class="bi bi-calculator-fill"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">{{ __('Total Quotes') }}</span>
                        <div class="dash-kpi-value text-dark">{{ $quoteCounts['total'] }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <small class="text-muted">{{ __('Contacted') }}: <strong class="text-success">{{ $quoteCounts['contacted'] }}</strong></small>
                    <small class="text-muted">{{ __('Reviewed') }}: <strong class="text-warning">{{ $quoteCounts['reviewed'] }}</strong></small>
                </div>
            </a>
        </div>

        {{-- CARD 3: HEALTHCARE SERVICES --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ url('services') }}" target="_blank" class="dash-card dash-kpi text-decoration-none h-100 p-3">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dash-kpi-icon" style="background: #ccfbf1; color: #0d9488;">
                        <i class="bi bi-hospital-fill"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">{{ __('Offered Services') }}</span>
                        <div class="dash-kpi-value text-dark">{{ $servicesCount }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <small class="text-muted"><i class="bi bi-check-circle text-success me-1"></i>{{ __('Active on Website') }}</small>
                    <span class="small text-primary fw-medium">{{ __('Preview') }} &rarr;</span>
                </div>
            </a>
        </div>

        {{-- CARD 4: AI ASSISTANT INQUIRIES --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('admin.assistant.queries.index') }}" class="dash-card dash-kpi text-decoration-none h-100 p-3">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dash-kpi-icon" style="background: #f3e8ff; color: #9333ea;">
                        <i class="bi bi-chat-heart-fill"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">{{ __('AI & Search Queries') }}</span>
                        <div class="dash-kpi-value text-dark">{{ $assistantQueriesCount }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <small class="text-muted">{{ __('Subscribers') }}: <strong class="text-dark">{{ $subscribersCount }}</strong></small>
                    <span class="small text-primary fw-medium">{{ __('Insights') }} &rarr;</span>
                </div>
            </a>
        </div>
    </div>

    {{-- MAIN CONTENT: 2 COLUMNS --}}
    <div class="row g-4">
        {{-- LEFT COLUMN: LATEST INQUIRIES & CHART --}}
        <div class="col-12 col-xl-8">
            {{-- LATEST QUOTE INQUIRIES CARD --}}
            <div class="dash-card mb-4 overflow-hidden">
                <div class="p-3 px-4 border-bottom d-flex align-items-center justify-content-between bg-white">
                    <div>
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-clock-history text-primary"></i>
                            {{ __('Recent Healthcare Quote Requests') }}
                        </h6>
                        <small class="text-muted">{{ __('Latest practice leads submitted via /get-quote & contact forms') }}</small>
                    </div>
                    <a href="{{ route('admin.quote_request.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        {{ __('View All Quotes') }} &rarr;
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="text-secondary small">
                                <th class="ps-4">{{ __('Client / Practice') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Contact Phone') }}</th>
                                <th>{{ __('Requested Services') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="pe-4 text-end">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestQuotes as $quote)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $quote->name }}</div>
                                        <small class="text-muted">{{ $quote->email ?: __('No email provided') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border small">
                                            {{ $quote->client_type ?: __('General') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $quote->phone }}" class="text-dark fw-semibold text-decoration-none">
                                            <i class="bi bi-telephone text-primary me-1"></i>{{ $quote->phone }}
                                        </a>
                                    </td>
                                    <td>
                                        @if (!empty($quote->services) && is_array($quote->services))
                                            <div class="d-flex flex-wrap gap-1" style="max-width: 220px;">
                                                @foreach (array_slice($quote->services, 0, 2) as $s)
                                                    <span class="badge bg-secondary-subtle text-secondary small py-0 px-2" style="font-size: 0.72rem;">{{ $s }}</span>
                                                @endforeach
                                                @if (count($quote->services) > 2)
                                                    <span class="badge bg-light text-muted small py-0 px-1">+{{ count($quote->services) - 2 }}</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted small">&mdash;</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($quote->status == 'pending')
                                            <span class="badge badge-pending px-2 py-1 rounded-pill small">{{ __('Pending') }}</span>
                                        @elseif ($quote->status == 'reviewed')
                                            <span class="badge badge-reviewed px-2 py-1 rounded-pill small">{{ __('Reviewed') }}</span>
                                        @elseif ($quote->status == 'contacted')
                                            <span class="badge badge-contacted px-2 py-1 rounded-pill small">{{ __('Contacted') }}</span>
                                        @else
                                            <span class="badge bg-light text-dark border small">{{ ucfirst($quote->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('admin.quote_request.detail', $quote->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 py-1">
                                            <i class="bi bi-eye me-1"></i>{{ __('Details') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                        <strong>{{ __('No quote requests yet') }}</strong>
                                        <p class="small text-muted mb-0">{{ __('Quote submissions from prospective clinics will appear here.') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 30-DAY INQUIRIES TREND CHART --}}
            <div class="dash-card p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">{{ __('Quote & Request Activity Trend') }}</h6>
                        <small class="text-muted">{{ __('Daily inquiry traffic over the last 30 days') }}</small>
                    </div>
                    <span class="badge bg-light text-secondary border small">{{ __('30 Days') }}</span>
                </div>
                <div class="dash-chart">
                    <canvas id="requestTrendChart"></canvas>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: QUICK SHORTCUTS & SYSTEM HEALTH --}}
        <div class="col-12 col-xl-4">
            {{-- QUICK SHORTCUTS --}}
            <div class="dash-card p-4 mb-4">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-lightning-charge-fill text-warning"></i>
                    {{ __('Quick Management Actions') }}
                </h6>

                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('admin.quote_request.index') }}" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-calculator text-primary"></i>
                            {{ __('Quote Requests') }}
                        </span>
                        @if ($quoteCounts['pending'] > 0)
                            <span class="badge bg-danger rounded-pill">{{ $quoteCounts['pending'] }}</span>
                        @else
                            <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                        @endif
                    </a>

                    <a href="{{ route('admin.setting.logo.icon') }}" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-image text-info"></i>
                            {{ __('Logo & Favicon Setting') }}
                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>

                    <a href="{{ route('admin.setting.sitemap') }}" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-diagram-3 text-success"></i>
                            {{ __('XML Sitemap Manager') }}
                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>

                    <a href="{{ route('admin.setting.robots') }}" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-robot text-dark"></i>
                            {{ __('Robots.txt Editor') }}
                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>

                    <a href="{{ route('admin.frontend.sections', 'seo') }}" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-google text-danger"></i>
                            {{ __('SEO & Verification') }}
                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>

                    <a href="{{ route('admin.frontend.sections', 'footer') }}" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-layout-text-window-reverse text-secondary"></i>
                            {{ __('Footer Settings & Info') }}
                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>

                    <a href="{{ route('admin.assistant.queries.index') }}" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-chat-heart text-purple" style="color: #9333ea;"></i>
                            {{ __('AI Assistant Inquiries') }}
                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>
                </div>
            </div>

            {{-- SYSTEM & OPERATIONAL STATUS --}}
            <div class="dash-card p-4">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-cpu text-primary"></i>
                    {{ __('Healthcare Platform Health') }}
                </h6>

                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted">{{ __('Newsletter Subscribers') }}</span>
                        <span class="fw-bold text-dark">{{ $subscribersCount }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted">{{ __('Support Tickets') }}</span>
                        <span class="fw-bold text-dark">{{ $stats['people']['support'] ?? 0 }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted">{{ __('Framework Version') }}</span>
                        <span class="badge bg-light text-dark border">Laravel {{ app()->version() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted">{{ __('PHP Environment') }}</span>
                        <span class="badge bg-light text-dark border">PHP {{ PHP_VERSION }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted">{{ __('Agency Brand') }}</span>
                        <strong class="text-primary">{{ gs('site_name') }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{ asset('assets/admin/js/chart.js') }}"></script>
    <script>
        'use strict';

        var trendCtx = document.getElementById('requestTrendChart');
        if (trendCtx) {
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: @json(array_keys($trend)),
                    datasets: [{
                        label: @json(__('Quote Requests')),
                        data: @json(array_values($trend)),
                        borderColor: '#19b5a5',
                        backgroundColor: 'rgba(25, 181, 165, 0.12)',
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointBackgroundColor: '#081C36',
                        fill: true,
                        tension: 0.35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    </script>
@endpush
