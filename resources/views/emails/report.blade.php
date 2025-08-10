@if ($contentType === 'business')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($reportType) }} Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .email-container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2c5530 0%, #4a7c59 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .header .date {
            font-size: 16px;
            opacity: 0.9;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 10px;
        }

        .content {
            padding: 30px;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .metric-card {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .metric-card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            padding: 20px;
            font-weight: 600;
            font-size: 18px;
            color: white;
            display: flex;
            align-items: center;
        }

        .card-header.eggs {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        }

        .card-header.chickens {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }

        .card-header.finance {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        }

        .card-icon {
            font-size: 24px;
            margin-right: 12px;
        }

        .card-content {
            padding: 20px;
        }

        .metric-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .metric-item:last-child {
            border-bottom: none;
        }

        .metric-label {
            color: #666;
            font-weight: 500;
        }

        .metric-value {
            font-weight: 700;
            font-size: 16px;
            color: #2c3e50;
        }

        .metric-value.positive {
            color: #27ae60;
        }

        .metric-value.negative {
            color: #e74c3c;
        }

        .alerts {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .alerts h3 {
            color: #e53e3e;
            margin-bottom: 15px;
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .alerts-icon {
            margin-right: 8px;
            font-size: 20px;
        }

        .alert-item {
            background: white;
            border-left: 4px solid #e53e3e;
            padding: 12px 16px;
            margin-bottom: 10px;
            border-radius: 0 6px 6px 0;
            color: #744210;
        }

        .alert-item:last-child {
            margin-bottom: 0;
        }

        .summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .summary h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .summary-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .summary-stat {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
        }

        .summary-stat .label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-stat .value {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            margin-top: 5px;
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .footer p {
            margin-bottom: 5px;
        }

        .divider {
            height: 2px;
            background: linear-gradient(90deg, #2c5530, #4a7c59, #2c5530);
            margin: 20px 0;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .metrics-grid {
                grid-template-columns: 1fr;
            }

            .summary-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .header {
                padding: 20px;
            }

            .content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>🐓 {{ ucfirst($reportType) }} Farm Report</h1>
            <div class="date">📅 Generated: {{ now()->format('F j, Y \a\t g:i A') }}</div>
        </div>

        <div class="content">
            <!-- Quick Summary -->
            <div class="summary">
                <h3>📊 Quick Overview</h3>
                <div class="summary-stats">
                    <div class="summary-stat">
                        <div class="label">Total Revenue</div>
                        <div class="value">${{ number_format(($reportData['revenue']['chickens'] ?? 0) + ($reportData['revenue']['eggs'] ?? 0), 2) }}</div>
                    </div>
                    <div class="summary-stat">
                        <div class="label">Net Profit</div>
                        <div class="value">${{ number_format($reportData['profit'] ?? 0, 2) }}</div>
                    </div>
                    <div class="summary-stat">
                        <div class="label">Live Chickens</div>
                        <div class="value">{{ ($reportData['chickens']['total_chickens'] ?? 0) - ($reportData['chickens']['sold_chickens'] ?? 0) - ($reportData['chickens']['slaughtered_chickens'] ?? 0) - ($reportData['chickens']['dead_chickens'] ?? 0) }}</div>
                    </div>
                    <div class="summary-stat">
                        <div class="label">Egg Stock</div>
                        <div class="value">{{ $reportData['eggs']['remaining_eggs'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Detailed Metrics -->
            <div class="metrics-grid">
                <!-- Eggs Card -->
                <div class="metric-card">
                    <div class="card-header eggs">
                        <span class="card-icon">🥚</span>
                        <span>Egg Production</span>
                    </div>
                    <div class="card-content">
                        <div class="metric-item">
                            <span class="metric-label">Total Eggs Produced</span>
                            <span class="metric-value">{{ number_format($reportData['eggs']['total_eggs'] ?? 0) }}</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Eggs Sold</span>
                            <span class="metric-value positive">{{ number_format($reportData['eggs']['sold_eggs'] ?? 0) }}</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Remaining Stock</span>
                            <span class="metric-value">{{ number_format($reportData['eggs']['remaining_eggs'] ?? 0) }}</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Broken/Lost</span>
                            <span class="metric-value negative">{{ number_format($reportData['eggs']['broken_eggs'] ?? 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Chickens Card -->
                <div class="metric-card">
                    <div class="card-header chickens">
                        <span class="card-icon">🐔</span>
                        <span>Chicken Inventory</span>
                    </div>
                    <div class="card-content">
                        <div class="metric-item">
                            <span class="metric-label">Total Chickens</span>
                            <span class="metric-value">{{ number_format($reportData['chickens']['total_chickens'] ?? 0) }}</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Sold</span>
                            <span class="metric-value positive">{{ number_format($reportData['chickens']['sold_chickens'] ?? 0) }}</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Processed</span>
                            <span class="metric-value">{{ number_format($reportData['chickens']['slaughtered_chickens'] ?? 0) }}</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Deceased</span>
                            <span class="metric-value negative">{{ number_format($reportData['chickens']['dead_chickens'] ?? 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Finance Card -->
                <div class="metric-card">
                    <div class="card-header finance">
                        <span class="card-icon">💰</span>
                        <span>Financial Summary</span>
                    </div>
                    <div class="card-content">
                        <div class="metric-item">
                            <span class="metric-label">Chicken Sales Revenue</span>
                            <span class="metric-value positive">${{ number_format($reportData['revenue']['chickens'] ?? 0, 2) }}</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Egg Sales Revenue</span>
                            <span class="metric-value positive">${{ number_format($reportData['revenue']['eggs'] ?? 0, 2) }}</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Total Expenses</span>
                            <span class="metric-value negative">${{ number_format($reportData['expenses'] ?? 0, 2) }}</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label"><strong>Net Profit</strong></span>
                            <span class="metric-value {{ ($reportData['profit'] ?? 0) >= 0 ? 'positive' : 'negative' }}">${{ number_format($reportData['profit'] ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if(!empty($reportData['alerts']))
            <!-- Alerts Section -->
            <div class="alerts">
                <h3><span class="alerts-icon">⚠️</span>Attention Required</h3>
                @foreach($reportData['alerts'] as $alert)
                <div class="alert-item">
                    {{ $alert }}
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="footer">
            <p><strong>Farm Management System</strong></p>
            <p>Automated Report Generation</p>
            <p style="margin-top: 10px; font-size: 14px; opacity: 0.8;">
                For questions or support, please contact your system administrator
            </p>
        </div>
    </div>
</body>

</html>
@elseif ($contentType === 'batch')
{{-- New batch wise summary content in table format --}}
<div class="email-container">
    <div class="header">
        <h1>🐓 {{ ucfirst($reportType) }} Batch Wise Summary</h1>
        <div class="date">📅 Generated: {{ now()->format('F j, Y \a\t g:i A') }}</div>
    </div>

    <div class="content">
        <table class="batch-summary-table" style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <thead>
                <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Batch Code</th>
                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: bold;">Total Eggs</th>
                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: bold;">Sold Eggs</th>
                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: bold;">Broken Eggs</th>
                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: bold;">Remaining Eggs</th>
                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: bold;">Total Chickens</th>
                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: bold;">Sold Chickens</th>
                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: bold;">Processed Chickens</th>
                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: bold;">Deceased Chickens</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($reportData['batch_wise_summary'] as $index => $batch)

                <tr style="border-bottom: 1px solid #dee2e6; background-color: #f8f9fa;">

                    <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: 500;">
                        {{ $batch['batch_code'] }}
                    </td>

                    <td style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">
                        {{ number_format($batch['eggs']['total_eggs']) }}
                    </td>

                    <td style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">
                        {{ number_format($batch['eggs']['sold_eggs']) }}
                    </td>

                    <td style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">
                        {{ number_format($batch['eggs']['broken_eggs']) }}
                    </td>

                    <td style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">
                        {{ number_format($batch['eggs']['remaining_eggs']) }}
                    </td>

                    <td style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">
                        {{ number_format($batch['chickens']['total_chickens']) }}
                    </td>

                    <td style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">
                        {{ number_format($batch['chickens']['sold_chickens']) }}
                    </td>

                    <td style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">
                        {{ number_format($batch['chickens']['slaughtered_chickens']) }}
                    </td>

                    <td style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">
                        {{ number_format($batch['chickens']['dead_chickens']) }}
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Summary totals table (optional) --}}
        <div style="margin-top: 30px;">
            <h3 style="color: #495057; margin-bottom: 15px;">📊 Summary Totals</h3>
            <table style="width: 100%; border-collapse: collapse; background-color: #e9ecef;">
                <tr>
                    <td style="padding: 10px; border: 1px solid #adb5bd; font-weight: bold;">Total Batches:</td>
                    <td style="padding: 10px; border: 1px solid #adb5bd; text-align: center;">
                        {{ count($reportData['batch_wise_summary']) }}
                    </td>
                    <td style="padding: 10px; border: 1px solid #adb5bd; font-weight: bold;">Total Eggs:</td>
                    <td style="padding: 10px; border: 1px solid #adb5bd; text-align: center;">
                        {{ number_format(collect($reportData['batch_wise_summary'])->sum('eggs.total_eggs')) }}
                    </td>
                    <td style="padding: 10px; border: 1px solid #adb5bd; font-weight: bold;">Total Chickens:</td>
                    <td style="padding: 10px; border: 1px solid #adb5bd; text-align: center;">
                        {{ number_format(collect($reportData['batch_wise_summary'])->sum('chickens.total_chickens')) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="footer">
    <p><strong>Farm Management System</strong></p>
    <p>Automated Batch Summary Report</p>
</div>
</div>
@endif