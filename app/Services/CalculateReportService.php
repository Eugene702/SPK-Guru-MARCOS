<?php
namespace App\Services;

use App\Models\Perhitungan;

class CalculateReportService
{
    public function calculate($data = null)
    {
        $calculation = null;
        if ($data) {
            $calculation = $data;
        } else {
            $calculation = Perhitungan::whereHas('guru', function ($query) {
                $query->where('jabatan', '=', 'Guru');
            })
                ->whereYear('created_at', now()->year)
                ->with('guru.user')
                ->get();
        }

        $scoreWeights = [
            'supervisi' => 0.18,
            'administrasi' => 0.15,
            'presensi' => 0.17,
            'kehadiran_dikelas' => 0.15,
            'sertifikat_pengembangan' => 0.12,
            'kegiatan_sosial' => 0.13,
            'rekan_sejawat' => 0.10,
        ];

        $data = $calculation->map(function ($item) {
            $formatScore = function ($score, $isAdmin = false) {
                if ($isAdmin) {
                    if ($score == 4) {
                        return "Lengkap";
                    } else if ($score == 3) {
                        return 'Cukup';
                    } else if ($score == 2) {
                        return 'Kurang';
                    } else {
                        return 'Tidak Ada';
                    }
                } else {
                    if ($score == 4) {
                        return "Sangat Baik";
                    } else if ($score == 3) {
                        return 'Baik';
                    } else if ($score == 2) {
                        return 'Cukup';
                    } else if ($score == 1) {
                        return 'Kurang';
                    } else {
                        return 'Tidak Ada';
                    }
                }
            };

            // skor awal
            return [
                'guru_id' => $item->guru_id,
                'nama' => $item->guru->user->name ?? 'Nama tidak tersedia',
                'supervisi' => round($item->supervisi, 4) ?? 0,
                'administrasi' => $formatScore(round($item->administrasi ?? 0), true),
                'presensi' => $formatScore(round($item->presensi ?? 0)),
                'kehadiran_dikelas' => $formatScore(round($item->kehadiran_dikelas ?? 0)),
                'sertifikat_pengembangan' => $item->sertifikat_pengembangan ?? 0,
                'kegiatan_sosial' => $item->kegiatan_sosial ?? 0,
                'rekan_sejawat' => round($item->rekan_sejawat,4) ?? 0,
            ];
        });

        // langkah 2
        $liguistics = $calculation->map(function ($item) {
            return [
                'guru_id' => $item->guru_id,
                'nama' => $item->guru->user->name ?? 'Nama tidak tersedia',
                'supervisi' => round($item->supervisi, 4) ?? 0,
                'administrasi' => $item->administrasi ?? 0,
                'presensi' => $item->presensi ?? 0,
                'kehadiran_dikelas' => $item->kehadiran_dikelas ?? 0,
                'sertifikat_pengembangan' => $item->sertifikat_pengembangan ?? 0,
                'kegiatan_sosial' => $item->kegiatan_sosial ?? 0,
                'rekan_sejawat' => round($item->rekan_sejawat,4) ?? 0,
            ];
        });

        // langkah 3
        $idealSolution = [
            'data' => $liguistics->toArray(),
            'aai' => collect($scoreWeights)->map(function ($_, $key) use ($liguistics) {
                return $liguistics->pluck($key)->min();
            })->toArray(),
            'ai' => collect($scoreWeights)->map(function ($_, $key) use ($liguistics) {
                return $liguistics->pluck($key)->max();
            })->toArray(),
        ];

        // // langkah 4
        // $normalized = [
        //     'data' => collect($idealSolution['data'])->map(function ($item) use ($scoreWeights, $idealSolution) {
        //         return array_merge(
        //             ['guru_id' => $item['guru_id'], 'nama' => $item['nama']],
        //             collect($scoreWeights)->map(function ($_, $keyWeight) use ($item, $idealSolution) {
        //                 $value = $item[$keyWeight];
        //                 return $value != 0 ? $value / $idealSolution['ai'][$keyWeight] : 0;
        //             })->toArray()
        //         );
        //     })->toArray(),
        //     'aai' => collect($scoreWeights)->map(function ($_, $keyWeight) use ($idealSolution) {
        //         $value = $idealSolution['aai'][$keyWeight];
        //         return $value != 0 ? $value / $idealSolution['ai'][$keyWeight] : 0;
        //     })->toArray(),
        //     'ai' => collect($scoreWeights)->map(function ($_, $keyWeight) use ($idealSolution) {
        //         $value = $idealSolution['ai'][$keyWeight];
        //         return $value != 0 ? $value / $idealSolution['ai'][$keyWeight] : 0;
        //     })->toArray(),
        // ];

        // langkah 4
        $normalized = [
            'data' => collect($idealSolution['data'])->map(function ($item) use ($scoreWeights, $idealSolution) {
                return array_merge(
                    ['guru_id' => $item['guru_id'], 'nama' => $item['nama']],
                    collect($scoreWeights)->map(function ($_, $keyWeight) use ($item, $idealSolution) {
                        $value = $item[$keyWeight];
                        $aiValue = $idealSolution['ai'][$keyWeight];
                        // Lakukan pembulatan setelah pembagian
                        $normalizedValue = ($aiValue != 0) ? ($value / $aiValue) : 0;
                        return round($normalizedValue, 4); 
                    })->toArray()
                );
            })->toArray(),
            'aai' => collect($scoreWeights)->map(function ($_, $keyWeight) use ($idealSolution) {
                $value = $idealSolution['aai'][$keyWeight];
                $aiValue = $idealSolution['ai'][$keyWeight];
                // Lakukan pembulatan setelah pembagian
                $normalizedValue = ($aiValue != 0) ? ($value / $aiValue) : 0;
                return round($normalizedValue, 4);
            })->toArray(),
            'ai' => collect($scoreWeights)->map(function ($_, $keyWeight) use ($idealSolution) {
                $value = $idealSolution['ai'][$keyWeight];
                $aiValue = $idealSolution['ai'][$keyWeight];
                // Lakukan pembulatan setelah pembagian
                $normalizedValue = ($aiValue != 0) ? ($value / $aiValue) : 0;
                return round($normalizedValue, 4);
            })->toArray(),
        ];

        // langkah 5
        // $weighting = [
        //     'data' => collect($normalized['data'])->map(function ($item) use ($scoreWeights) {
        //         return array_merge(
        //             ['guru_id' => $item['guru_id'], 'nama' => $item['nama']],
        //             collect($scoreWeights)->map(function ($weight, $keyWeight) use ($item) {
        //                 return $item[$keyWeight] * $weight;
        //             })->toArray()
        //         );
        //     })->toArray(),
        //     'aai' => collect($scoreWeights)->map(function ($weight, $keyWeight) use ($normalized) {
        //         return $normalized['aai'][$keyWeight] * $weight;
        //     })->toArray(),
        //     'ai' => collect($scoreWeights)->map(function ($weight, $keyWeight) use ($normalized) {
        //         return $normalized['ai'][$keyWeight] * $weight;
        //     })->toArray(),
        // ];

        // langkah 5
        $weighting = [
            'data' => collect($normalized['data'])->map(function ($item) use ($scoreWeights) {
                return array_merge(
                    ['guru_id' => $item['guru_id'], 'nama' => $item['nama']],
                    collect($scoreWeights)->map(function ($weight, $keyWeight) use ($item) {
                        // Lakukan pembulatan setelah perkalian
                        return round($item[$keyWeight] * $weight, 4);
                    })->toArray()
                );
            })->toArray(),
            'aai' => collect($scoreWeights)->map(function ($weight, $keyWeight) use ($normalized) {
                // Lakukan pembulatan setelah perkalian
                return round($normalized['aai'][$keyWeight] * $weight, 4);
            })->toArray(),
            'ai' => collect($scoreWeights)->map(function ($weight, $keyWeight) use ($normalized) {
                // Lakukan pembulatan setelah perkalian
                return round($normalized['ai'][$keyWeight] * $weight, 4);
            })->toArray(),
        ];

        // langkah 6
        $utility = function () use ($weighting, $scoreWeights) {
            $aai_si = collect($weighting['aai'])->sum();
            $ai_si = collect($weighting['ai'])->sum();
            return [
                'data' => collect($weighting['data'])->map(function ($item) use ($aai_si, $scoreWeights, $ai_si) {
                    $si = collect($item)->only(collect($scoreWeights)->keys())->sum();
                    $kiMinus = $si / $aai_si;
                    $kiPlus = $si / $ai_si;
                    return [
                        'guru_id' => $item['guru_id'],
                        'nama' => $item['nama'],
                        'si' => $si,
                        'kiMinus' => $kiMinus,
                        'kiPlus' => $kiPlus,
                    ];
                })->toArray(),
                'aai' => ['si' => $aai_si],
                'ai' => ['si' => $ai_si],
            ];
        };
        $utilityResult = $utility();

        // langkah 7
        $utilityFinal = collect($utilityResult['data'])->map(function ($item) {
            $fkMinus = $item['kiMinus'] / ($item['kiMinus'] + $item['kiPlus']);
            $fkPlus = $item['kiPlus'] / ($item['kiPlus'] + $item['kiMinus']);
            $fk = ($item['kiPlus'] + $item['kiMinus']) /
                (
                    ((1 - $fkPlus) / $fkPlus) +
                    ((1 - $fkMinus) / $fkMinus) +
                    1
                );

            return [
                'guru_id' => $item['guru_id'],
                'nama' => $item['nama'],
                'fkMinus' => $fkMinus,
                'fkPlus' => $fkPlus,
                'fk' => $fk
            ];
        })->toArray();

        // langkah 8
        $ranking = collect($utilityFinal)->map(function ($item) {
            return [
                'guru_id' => $item['guru_id'],
                'nama' => $item['nama'],
                'fk' => $item['fk']
            ];
        })
            ->sortByDesc(['fk'])
            ->toArray();

        return compact(
            'scoreWeights',
            'data',
            'liguistics',
            'idealSolution',
            'normalized',
            'weighting',
            'utilityResult',
            'utilityFinal',
            'ranking'
        );
    }
}