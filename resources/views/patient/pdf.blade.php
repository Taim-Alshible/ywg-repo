<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تقرير المرضى</title>
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

    <h1>{{ $glyph('تقرير المرضى') }}</h1>
    <div class="meta">
        <span>{{ $glyph('تاريخ التوليد: ') }}{{ $generatedAt->format('Y-m-d H:i') }}</span>
        @if (!empty($searchTerm))
            <span>{{ $glyph('نتيجة بحث عن: ') }}{{ $glyph($searchTerm) }}</span>
        @else
            <span>{{ $glyph('عرض جميع المرضى') }}</span>
        @endif
    </div>

    @if ($patients->isEmpty())
        <div class="empty">{{ $glyph('لا توجد سجلات مرضى مطابقة.') }}</div>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width: 6%;">{{ $glyph('المعرف') }}</th>
                    <th style="width: 20%;">{{ $glyph('اسم المريض') }}</th>
                    <th style="width: 10%;">{{ $glyph('العمر') }}</th>
                    <th style="width: 14%;">{{ $glyph('التخصص المطلوب') }}</th>
                    <th style="width: 25%;">{{ $glyph('الأدوية') }}</th>
                    <th style="width: 13%;">{{ $glyph('الهاتف') }}</th>
                    <th style="width: 12%;">{{ $glyph('الموقع') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    @php
                        $medicines = $patient->medicines->map(function ($medicine) use ($glyph) {
                            $name = $glyph($medicine->name ?? '');
                            $titer = $glyph($medicine->titer ?? '');
                            $quantity = $medicine->quantity !== null ? $medicine->quantity : null;
                            $priority = $medicine->priority ? $glyph(match ($medicine->priority) {
                                'high' => 'عالية',
                                'medium' => 'متوسطة',
                                'low' => 'منخفضة',
                                default => $medicine->priority,
                            }) : null;

                            $parts = array_filter([
                                $name,
                                $titer ? $glyph('العيار: ') . $titer : null,
                                $quantity !== null ? $glyph('الكمية: ') . $quantity : null,
                                $priority ? $glyph('الأولوية: ') . $priority : null,
                            ]);

                            return implode(' - ', $parts);
                        })->filter();
                    @endphp
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $glyph(trim(sprintf('%s %s %s', $patient->fName, $patient->father_name, $patient->lName))) }}</td>
                        <td>{{ $patient->age }}</td>
                        <td>{{ $patient->specialty ? $glyph($patient->specialty) : $glyph('غير محدد') }}</td>
                        <td>
                            @if ($medicines->isEmpty())
                                {{ $glyph('لا توجد أدوية مسجلة') }}
                            @else
                                <ul style="margin: 0; padding-right: 16px;">
                                    @foreach ($medicines as $medicine)
                                        <li style="margin-bottom: 4px;">{{ $medicine }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>{{ $patient->phone }}</td>
                        <td>{{ $patient->location ? $glyph($patient->location) : $glyph('غير محدد') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
