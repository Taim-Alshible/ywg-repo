<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تقرير المستفيدين</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            margin: 0;
            padding: 24px;
            color: #1f2937;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .meta {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: right;
            word-break: break-word;
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

            $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

            return $arabic->utf8Glyphs($text);
        };
    @endphp

    <h1>{{ $glyph('تقرير المستفيدين') }}</h1>
    <div class="meta">
        <span>{{ $glyph('تاريخ التوليد: ') }}{{ $generatedAt->format('Y-m-d H:i') }}</span>
        @if (!empty($searchTerm))
            <span>{{ $glyph('نتيجة بحث عن: ') }}{{ $glyph($searchTerm) }}</span>
        @else
            <span>{{ $glyph('عرض جميع المستفيدين') }}</span>
        @endif
    </div>

    @if ($beneficiaries->isEmpty())
        <div class="empty">{{ $glyph('لا توجد سجلات مستفيدين مطابقة.') }}</div>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width: 6%;">{{ $glyph('المعرف') }}</th>
                    <th style="width: 18%;">{{ $glyph('اسم المستفيد') }}</th>
                    <th style="width: 8%;">{{ $glyph('العمر') }}</th>
                    <th style="width: 12%;">{{ $glyph('عدد أفراد العائلة') }}</th>
                    <th style="width: 22%;">{{ $glyph('الاحتياجات') }}</th>
                    <th style="width: 12%;">{{ $glyph('الهاتف') }}</th>
                    <th style="width: 22%;">{{ $glyph('الموقع') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($beneficiaries as $beneficiary)
                    @php
                        $needsList = $beneficiary->needs->map(function ($need) use ($glyph) {
                            $parts = [
                                $glyph($need->name ?? ''),
                            ];

                            if ($need->pivot) {
                                if (!is_null($need->pivot->quantity)) {
                                    $parts[] = $glyph('الكمية: ') . $need->pivot->quantity;
                                }
                                if (!is_null($need->pivot->priority)) {
                                    $priorityLabel = match ($need->pivot->priority) {
                                        'high' => 'عالية',
                                        'medium' => 'متوسطة',
                                        'low' => 'منخفضة',
                                        default => $need->pivot->priority,
                                    };
                                    $parts[] = $glyph('الأولوية: ') . $glyph($priorityLabel);
                                }
                                if (!is_null($need->pivot->delivered)) {
                                    $parts[] = $glyph('التسليم: ') . ($need->pivot->delivered ? $glyph('تم') : $glyph('لم يتم'));
                                }
                            }

                            return implode(' - ', array_filter($parts));
                        })->filter();
                    @endphp
                    <tr>
                        <td>{{ $beneficiary->id }}</td>
                        <td>{{ $glyph(trim(sprintf('%s %s %s', $beneficiary->fName, $beneficiary->father_name, $beneficiary->lName))) }}</td>
                        <td>{{ $beneficiary->age }}</td>
                        <td>{{ $beneficiary->numOfPeople }}</td>
                        <td>
                            @if ($needsList->isEmpty())
                                {{ $glyph('لا توجد احتياجات مسجلة') }}
                            @else
                                <ul style="margin: 0; padding-right: 16px;">
                                    @foreach ($needsList as $need)
                                        <li style="margin-bottom: 4px;">{{ $need }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>{{ $beneficiary->phone }}</td>
                        <td>{{ $glyph($beneficiary->location) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
