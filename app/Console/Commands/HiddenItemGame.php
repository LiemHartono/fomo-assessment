<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HiddenItemGame extends Command
{
    protected $signature = 'game:find-item {a} {b} {c}';
    protected $description = 'Task 2: Menemukan lokasi item tersembunyi pada grid';

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
        $a = (int) $this->argument('a');
        $b = (int) $this->argument('b');
        $c = (int) $this->argument('c');

        $currentRow = 4;
        $currentCol = 1;
        $pathBlocked = false;

        for ($i = 0; $i < $a; $i++) {
            $currentRow--;
            if ($this->isObstacle($currentRow, $currentCol)) { $pathBlocked = true; break; }
        }

        if (!$pathBlocked) {
            for ($i = 0; $i < $b; $i++) {
                $currentCol++;
                if ($this->isObstacle($currentRow, $currentCol)) { $pathBlocked = true; break; }
            }
        }

        if (!$pathBlocked) {
            for ($i = 0; $i < $c; $i++) {
                $currentRow++;
                if ($this->isObstacle($currentRow, $currentCol)) { $pathBlocked = true; break; }
            }
        }

        if ($pathBlocked || $this->isObstacle($currentRow, $currentCol)) {
            $this->error("Jalur terhalang '#' atau keluar batas! Tidak ada koordinat yang mungkin.");
        } else {
            $this->info("Kemungkinan lokasi item: [Row: $currentRow, Col: $currentCol]");

            $this->displayGrid($currentRow, $currentCol);
        }
    }

    private function isObstacle($r, $c)
    {
        return !isset($this->grid[$r][$c]) || $this->grid[$r][$c] === '#';
    }

    private function displayGrid($resR, $resC)
    {
        foreach ($this->grid as $r => $row) {
            $line = "";
            foreach ($row as $c => $char) {
                if ($r === $resR && $c === $resC) {
                    $line .= "$ ";
                } else {
                    $line .= $char . " ";
                }
            }
            $this->line($line);
        }
    }
}
