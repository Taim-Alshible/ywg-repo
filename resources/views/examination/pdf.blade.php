<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تقرير الفحوصات</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            margin: 0;
            padding: 24px;
            color: #1f2937;
        }

        h1 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .meta {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 20px;
            color: #374151;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 10px 12px;
            text-align: right;
        }

        th {
            white-space: nowrap;
            font-size: 12.5px;
            color: #1f2937;
        }

        td {
            word-break: normal;
            white-space: normal;
            line-height: 1.5;
        }

        thead {
            background-color: #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .empty {
            text-align: center;
            padding: 24px;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>

<body>
    @php
        $glyph = function ($text) use ($arabic) {
            if (!isset($arabic) || empty($text)) {
                return $text;
            }

            // Ensure string encoding is UTF-8 before shaping
            $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

            return $arabic->utf8Glyphs($text);
        };
    @endphp

    <h1>{{ $glyph('تقرير الفحوصات') }}</h1>
    <div class="meta">
        <span>{{ $glyph('تاريخ التوليد: ') }}{{ $generatedAt->format('Y-m-d H:i') }}</span>
        @if (!empty($searchTerm))
            <span>{{ $glyph('نتيجة بحث عن: ') }}{{ $glyph($searchTerm) }}</span>
        @else
            <span>{{ $glyph('عرض كل الفحوصات') }}</span>
        @endif
    </div>

    @if ($examinations->isEmpty())
        <div class="empty">{{ $glyph('لا توجد فحوصات مطابقة.') }}</div>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width: 6%;">{{ $glyph('المعرف') }}</th>
                    <th style="width: 20%;">{{ $glyph('اسم المريض') }}</th>
                    <th style="width: 14%;">{{ $glyph('التكلفة الكلية') }}</th>
                    <th style="width: 18%;">{{ $glyph('التحاليل') }}</th>
                    <th style="width: 18%;">{{ $glyph('الصور الشعاعية') }}</th>
                    <th style="width: 12%;">{{ $glyph('ملاحظات') }}</th>
                    <th style="width: 12%;">{{ $glyph('تاريخ الإدخال') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($examinations as $examination)
                    <tr>
                        <td>{{ $examination->id }}</td>
                        <td>
                            {{ $glyph(trim(sprintf('%s %s %s', $examination->patient->fName, $examination->patient->father_name, $examination->patient->lName))) }}
                        </td>
                        <td>
                            @php
                                $analysisEntries = $examination->analyses->map(function ($analysis) use ($glyph) {
                                    $parts = [$glyph($analysis->name ?? '')];
                                    if (!empty($analysis->cost)) {
                                        $parts[] = $glyph('التكلفة: ') . $analysis->cost;
                                    }
                                    if (!empty($analysis->note)) {
                                        $parts[] = $glyph('ملاحظة: ') . $glyph($analysis->note);
                                    }
                                    return implode(' - ', array_filter($parts));
                                })->filter();

                                $radiologyEntries = $examination->radiologies->map(function ($radiology) use ($glyph) {
                                    $parts = [$glyph($radiology->radiology_name ?? '')];
                                    if (!empty($radiology->radiology_cost)) {
                                        $parts[] = $glyph('التكلفة: ') . $radiology->radiology_cost;
                                    }
                                    if (!empty($radiology->radiology_note)) {
                                        $parts[] = $glyph('ملاحظة: ') . $glyph($radiology->radiology_note);
                                    }
                                    return implode(' - ', array_filter($parts));
                                })->filter();

                                $analysisCost = $examination->analyses->sum(fn ($analysis) => (float) $analysis->cost);
                                $radiologyCost = $examination->radiologies->sum(fn ($radiology) => (float) $radiology->radiology_cost);
                                $examCost = (float) $examination->cost;
                                $totalCost = $examCost + $analysisCost + $radiologyCost;
                            @endphp

                            {{ number_format($totalCost, 2) }}
                        </td>
                        <td>
                            @if ($analysisEntries->isEmpty())
                                {{ $glyph('لا يوجد') }}
                            @else
                                <ul style="margin: 0; padding-right: 16px;">
                                    @foreach ($analysisEntries as $entry)
                                        <li style="margin-bottom: 4px;">{{ $entry }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            @if ($radiologyEntries->isEmpty())
                                {{ $glyph('لا يوجد') }}
                            @else
                                <ul style="margin: 0; padding-right: 16px;">
                                    @foreach ($radiologyEntries as $entry)
                                        <li style="margin-bottom: 4px;">{{ $entry }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            {{ !empty($examination->notes) ? $glyph($examination->notes) : $glyph('لا يوجد') }}
                        </td>
                        <td>
                            {{ !empty($examination->created_at) ? $examination->created_at->format('Y-m-d') : '—' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
