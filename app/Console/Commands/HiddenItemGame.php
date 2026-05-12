<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HiddenItemGame extends Command
{
    /**
     * Signature command diubah agar tidak memerlukan argumen input {a} {b} {c}.
     */
    protected $signature = 'game:find-item';

    protected $description = 'Task 2: Menemukan daftar kemungkinan lokasi item tersembunyi pada grid';

    protected $grid = [
        ['#', '#', '#', '#', '#', '#', '#', '#'],
        ['#', '.', '.', '.', '.', '.', '.', '#'],
        ['#', '.', '#', '#', '#', '.', '.', '#'],
        ['#', '.', '.', '.', '#', '.', '#', '#'],
        ['#', 'X', '#', '.', '.', '.', '.', '#'],
        ['#', '#', '#', '#', '#', '#', '#', '#'],
    ];

    public function handle()
    {
        // Posisi awal 'X' berada di baris 4, kolom 1
        $startRow = 4;
        $startCol = 1;
        $rows = count($this->grid);
        $cols = count($this->grid[0]);

        $probableLocations = [];

        // 1. Eksplorasi langkah ke Utara / Up (A >= 1)
        for ($a = 1; $startRow - $a >= 0; $a++) {
            $rowA = $startRow - $a;
            $colA = $startCol;

            // Jika menabrak rintangan '#', jalur Utara ini dan seterusnya terputus
            if ($this->grid[$rowA][$colA] === '#') {
                break;
            }

            // 2. Eksplorasi langkah ke Timur / Right (B >= 1) dari titik ($rowA, $colA)
            for ($b = 1; $colA + $b < $cols; $b++) {
                $rowB = $rowA;
                $colB = $colA + $b;

                // Jika menabrak rintangan '#', jalur Timur ini terputus
                if ($this->grid[$rowB][$colB] === '#') {
                    break;
                }

                // 3. Eksplorasi langkah ke Selatan / Down (C >= 1) dari titik ($rowB, $colB)
                for ($c = 1; $rowB + $c < $rows; $c++) {
                    $rowC = $rowB + $c;
                    $colC = $colB;

                    // Jika menabrak rintangan '#', jalur Selatan ini terputus
                    if ($this->grid[$rowC][$colC] === '#') {
                        break;
                    }

                    // Jika berhasil melewati semua syarat, simpan titik akhir sebagai lokasi yang mungkin
                    $probableLocations[] = [
                        'row' => $rowC,
                        'col' => $colC,
                        'path' => "North: $a, East: $b, South: $c"
                    ];
                }
            }
        }

        // Jika tidak ada lokasi yang ditemukan
        if (empty($probableLocations)) {
            $this->error("Tidak ada titik koordinat yang memenuhi syarat pergerakan.");
            return;
        }

        // Output daftar kemungkinan titik koordinat
        $this->info("List of probable coordinate points:");

        $markedCoords = [];
        foreach ($probableLocations as $loc) {
            $this->line("- [Row: {$loc['row']}, Col: {$loc['col']}] (Path: {$loc['path']})");
            // Menyimpan key koordinat untuk mempermudah pencetakan simbol '$' di grid
            $markedCoords["{$loc['row']}_{$loc['col']}"] = true;
        }

        $this->newLine();
        $this->info("Grid map with probable item locations marked ($):");
        $this->displayGrid($markedCoords);
    }

    /**
     * Menampilkan grid dan mengganti titik akhir yang valid dengan simbol '$'
     */
    private function displayGrid(array $markedCoords)
    {
        foreach ($this->grid as $r => $row) {
            $line = "";
            foreach ($row as $c => $char) {
                // Jika titik koordinat ada di dalam daftar kemungkinan, ganti '.' menjadi '$'
                if (isset($markedCoords["{$r}_{$c}"]) && $char === '.') {
                    $line .= "$ ";
                } else {
                    $line .= $char . " ";
                }
            }
            $this->line($line);
        }
    }
}
