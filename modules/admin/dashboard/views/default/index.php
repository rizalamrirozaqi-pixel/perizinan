<?php

use yii\helpers\Html;

$this->title = 'Dashboard Perizinan';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="main-content-container overflow-hidden">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h4 class="mb-0 fw-bold">Data Izin</h4>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="#" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="fw-medium"><?= Html::encode($this->title) ?></span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-3 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #f3e8ff; width: 50px; height: 50px;">
                            <i class="material-symbols-outlined fs-24" style="color: #8833ff;">input</i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-dark"><?= number_format($cardMasuk) ?></h3>
                            <span class="text-secondary small">Izin Masuk</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge rounded-pill px-2 py-1" style="background-color: #e6f7ef; color: #00ca8d; font-weight: 600; font-size: 11px;">
                            <i class="material-symbols-outlined fs-12 align-middle" style="font-weight: bold;">arrow_upward</i> 8%
                        </span>
                        <span class="text-secondary" style="font-size: 11px;">Bulan ini</span>
                    </div>
                    <div class="d-flex align-items-end justify-content-between" style="height: 40px; gap: 4px;">
                        <?php
                        $heights = [40, 60, 30, 35, 60, 25, 80, 40, 25, 70, 30, 45, 30, 50, 40];
                        foreach ($heights as $h): ?>
                            <div style="background-color: #a855f7; width: 100%; border-radius: 2px 2px 0 0; opacity: 0.8; height: <?= $h ?>%;"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-3 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #e0f2fe; width: 50px; height: 50px;">
                            <i class="material-symbols-outlined fs-24" style="color: #0ea5e9;">assignment_turned_in</i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-dark"><?= number_format($cardTerbit) ?></h3>
                            <span class="text-secondary small">Izin Terbit</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge rounded-pill px-2 py-1" style="background-color: #fee2e2; color: #ef4444; font-weight: 600; font-size: 11px;">
                            <i class="material-symbols-outlined fs-12 align-middle" style="font-weight: bold;">arrow_downward</i> 7%
                        </span>
                        <span class="text-secondary" style="font-size: 11px;">bulan ini</span>
                    </div>
                    <div class="mt-auto overflow-hidden" style="margin-bottom: -10px;">
                        <svg viewBox="0 0 100 25" preserveAspectRatio="none" style="width: 100%; height: 50px;">
                            <path d="M0,25 L0,20 Q15,18 30,12 T60,18 T100,10 L100,25 Z" fill="#e0f2fe"></path>
                            <path d="M0,20 Q15,18 30,12 T60,18 T100,10" fill="none" stroke="#3b82f6" stroke-width="2"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-3 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #ffedd5; width: 50px; height: 50px;">
                            <i class="material-symbols-outlined fs-24" style="color: #f97316;">cancel</i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-dark"><?= number_format($cardDitolak) ?></h3>
                            <span class="text-secondary small">Izin ditolak</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge rounded-pill px-2 py-1" style="background-color: #e6f7ef; color: #00ca8d; font-weight: 600; font-size: 11px;">
                            <i class="material-symbols-outlined fs-12 align-middle" style="font-weight: bold;">arrow_upward</i> 12%
                        </span>
                        <span class="text-secondary" style="font-size: 11px;">Bulan ini</span>
                    </div>
                    <div class="mt-3 px-1">
                        <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="width: 100%; height: 40px;">
                            <polyline points="0,28 15,20 30,22 45,18 60,20 75,15 90,20 100,12" fill="none" stroke="#f97316" stroke-width="2"></polyline>
                            <circle cx="15" cy="20" r="2" fill="#f97316" />
                            <circle cx="30" cy="22" r="2" fill="#f97316" />
                            <circle cx="45" cy="18" r="2" fill="#f97316" />
                            <circle cx="60" cy="20" r="2" fill="#f97316" />
                            <circle cx="75" cy="15" r="2" fill="#f97316" />
                            <circle cx="90" cy="20" r="2" fill="#f97316" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100 rounded-3 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title fw-bold mb-0 text-dark">Progress Data Izin</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light bg-white border-0 text-secondary dropdown-toggle" type="button">
                                6 Bulan Terakhir
                            </button>
                        </div>
                    </div>
                    <div style="height: 320px;">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 rounded-3 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title fw-bold mb-0 text-dark">Grafik Pie Izin</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light bg-white border-0 text-secondary dropdown-toggle" type="button">
                                Minggu Terakhir
                            </button>
                        </div>
                    </div>
                    <div class="position-relative d-flex justify-content-center align-items-center" style="height: 220px;">
                        <canvas id="pieChart"></canvas>
                    </div>

                    <div class="mt-4 d-flex justify-content-center gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle" style="width: 10px; height: 10px; background-color: #8833ff;"></span>
                            <span class="text-secondary" style="font-size: 11px; fw-bold">Izin Masuk</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle" style="width: 10px; height: 10px; background-color: #00ca8d;"></span>
                            <span class="text-secondary" style="font-size: 11px; fw-bold">Izin Selesai</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle" style="width: 10px; height: 10px; background-color: #ff7f26;"></span>
                            <span class="text-secondary" style="font-size: 11px; fw-bold">Izin ditolak</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title fw-bold mb-0 text-dark">Grafik Batang Data Izin</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light bg-white border-0 text-secondary dropdown-toggle" type="button">
                                Tahun Ini
                            </button>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-1" style="width: 10px; height: 10px; background-color: #8833ff;"></span>
                            <span class="text-secondary" style="font-size: 11px; font-weight: 500;">Izin Masuk</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-1" style="width: 10px; height: 10px; background-color: #00ca8d;"></span>
                            <span class="text-secondary" style="font-size: 11px; font-weight: 500;">Izin Selesai</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-1" style="width: 10px; height: 10px; background-color: #ff7f26;"></span>
                            <span class="text-secondary" style="font-size: 11px; font-weight: 500;">Izin ditolak</span>
                        </div>
                    </div>
                    <div style="height: 350px;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // --- AMBIL DATA DARI CONTROLLER (PHP -> JS) ---
        // Pastikan variabel ini dikirim dari controller
        const lineLabels = <?= json_encode($lineLabels ?? []) ?>;
        const lineMasuk = <?= json_encode($lineMasuk ?? []) ?>;
        const lineTerbit = <?= json_encode($lineTerbit ?? []) ?>;
        const lineDitolak = <?= json_encode($lineDitolak ?? []) ?>;

        const pieData = <?= json_encode($pieData ?? []) ?>;

        const barMasuk = <?= json_encode($barMasuk ?? []) ?>;
        const barTerbit = <?= json_encode($barTerbit ?? []) ?>;
        const barDitolak = <?= json_encode($barDitolak ?? []) ?>;

        // --- 1. CONFIG LINE CHART ---
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: [{
                        label: 'Izin Masuk',
                        data: lineMasuk,
                        borderColor: '#8833ff',
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                            gradient.addColorStop(0, 'rgba(136, 51, 255, 0.2)');
                            gradient.addColorStop(1, 'rgba(136, 51, 255, 0)');
                            return gradient;
                        },
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        borderWidth: 2
                    },
                    {
                        label: 'Izin Selesai',
                        data: lineTerbit,
                        borderColor: '#00ca8d',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        borderWidth: 2
                    },
                    {
                        label: 'Izin Ditolak',
                        data: lineDitolak,
                        borderColor: '#ff7f26',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 80,
                        ticks: {
                            stepSize: 20,
                            color: '#9ca3af'
                        },
                        grid: {
                            borderDash: [5, 5],
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#9ca3af'
                        }
                    }
                }
            }
        });

        // --- 2. CONFIG PIE CHART ---
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Izin Masuk', 'Izin Selesai', 'Izin Ditolak'],
                datasets: [{
                    data: pieData,
                    backgroundColor: ['#8833ff', '#00ca8d', '#ff7f26'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.raw + '%';
                            }
                        }
                    }
                }
            }
        });

        // --- 3. CONFIG BAR CHART ---
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Ags', 'Sept', 'Okt', 'Nov', 'Des'],
                datasets: [{
                        label: 'Izin Masuk',
                        data: barMasuk,
                        backgroundColor: '#8833ff',
                        barPercentage: 0.6,
                        categoryPercentage: 0.8,
                        borderRadius: 3
                    },
                    {
                        label: 'Izin Selesai',
                        data: barTerbit,
                        backgroundColor: '#00ca8d',
                        barPercentage: 0.6,
                        categoryPercentage: 0.8,
                        borderRadius: 3
                    },
                    {
                        label: 'Izin Ditolak',
                        data: barDitolak,
                        backgroundColor: '#ff7f26',
                        barPercentage: 0.6,
                        categoryPercentage: 0.8,
                        borderRadius: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 80,
                        title: {
                            display: true,
                            text: 'Persentase (%)'
                        },
                        ticks: {
                            stepSize: 20,
                            color: '#9ca3af'
                        },
                        grid: {
                            borderDash: [5, 5],
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#9ca3af'
                        }
                    }
                }
            }
        });
    });
</script>