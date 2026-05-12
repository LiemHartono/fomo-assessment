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
        $startRow = 4;
        $startCol = 1;
        $rows = count($this->grid);
        $cols = count($this->grid[0]);

        $probableLocations = [];

        for ($a = 1; $startRow - $a >= 0; $a++) {
            $rowA = $startRow - $a;
            $colA = $startCol;

            if ($this->grid[$rowA][$colA] === '#') {
                break;
            }

            for ($b = 1; $colA + $b < $cols; $b++) {
                $rowB = $rowA;
                $colB = $colA + $b;

                if ($this->grid[$rowB][$colB] === '#') {
                    break;
                }

                for ($c = 1; $rowB + $c < $rows; $c++) {
                    $rowC = $rowB + $c;
                    $colC = $colB;

                    if ($this->grid[$rowC][$colC] === '#') {
                        break;
                    }

                    $probableLocations[] = [
                        'row' => $rowC,
                        'col' => $colC,
                        'path' => "North: $a, East: $b, South: $c"
                    ];
                }
            }
        }

        if (empty($probableLocations)) {
            $this->error("Tidak ada titik koordinat yang memenuhi syarat pergerakan.");
            return;
        }

        $this->info("List of probable coordinate points:");

        $markedCoords = [];
        foreach ($probableLocations as $loc) {
            $this->line("- [Row: {$loc['row']}, Col: {$loc['col']}] (Path: {$loc['path']})");
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
