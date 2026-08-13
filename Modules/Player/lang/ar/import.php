<?php

return [

    'action' => [
        'import_pdf' => 'استيراد من PDF',
        'import_report' => 'تقرير الاستيراد',
    ],

    'field' => [
        'pdf_file' => 'ملف كشف اللاعبين (PDF)',
    ],

    'modal' => [
        'heading' => 'نتيجة استيراد اللاعبين',
        'close' => 'إغلاق',
    ],

    'summary' => 'تم إنشاء :created لاعب، وتحديث :updated لاعب.',
    'no_skipped' => 'مفيش صفوف اتخطت.',
    'skipped_count' => 'صفوف اتخطت (:count):',

    'table' => [
        'row_number' => '#',
        'name' => 'الاسم',
        'reason' => 'السبب',
    ],

    'reason' => [
        'invalid_national_id' => 'الرقم القومي غير صحيح',
        'unknown_belt' => 'الحزام غير معروف: ":belt"',
        'player_in_another_club' => 'اللاعب مسجل بالفعل في نادي آخر — يحتاج نقل يدوي',
    ],

];  