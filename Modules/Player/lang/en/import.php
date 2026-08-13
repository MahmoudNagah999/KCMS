<?php

return [

    'action' => [
        'import_pdf' => 'Import from PDF',
        'import_report' => 'Import Report',
    ],

    'field' => [
        'pdf_file' => 'Players List File (PDF)',
    ],

    'modal' => [
        'heading' => 'Player Import Result',
        'close' => 'Close',
    ],

    'summary' => 'Created :created player(s), updated :updated player(s).',
    'no_skipped' => 'No rows were skipped.',
    'skipped_count' => 'Skipped rows (:count):',

    'table' => [
        'row_number' => '#',
        'name' => 'Name',
        'reason' => 'Reason',
    ],

    'reason' => [
        'invalid_national_id' => 'Invalid national ID',
        'unknown_belt' => 'Unknown belt: ":belt"',
        'player_in_another_club' => 'Player already registered in another club — requires manual transfer',
    ],

];