<?php

namespace App\Http\Actions\Utility;

class GetSidebarMenu
{
    const ROLE_ADMIN = 'admin';
    const ROLE_CITIZEN = 'warga';
    const ROLE_OFFICER = 'petugas';
    const ROLE_GOVERNMENT = 'pemerintah';

    /**
     * Handle the action to get sidebar menu.
     *
     * @return array
     */
    public function handle(): array
    {
        $role = auth()->check() ? auth()->user()->role->name : 'tamu';

        // Item menu
        $menuItems = match ($role) {
            self::ROLE_ADMIN => $this->getAdminMenu(),
            self::ROLE_CITIZEN => $this->getCitizenMenu(),
            self::ROLE_OFFICER => $this->getOfficerMenu(),
            self::ROLE_GOVERNMENT => $this->getGovernmentMenu(),
            default => $this->getGuestMenu(),
        };

        return $menuItems;
    }

    private function getAdminMenu(): array
    {
        return [
            [
                'key' => '1',
                'title' => 'Dashboard',
                'icon' => 'DashboardOutlined',
                'route' => 'app.dashboard',
            ],
            [
                'key' => '2',
                'title' => 'Manajemen Wilayah',
                'icon' => 'GlobalOutlined',
                'route' => 'app.regions.index',
            ],

            [
                'key' => '3',
                'title' => 'Acara',
                'icon' => 'CalendarOutlined',
                'children' => [
                    [
                        'key' => '3-1',
                        'title' => 'Semua Acara',
                        'route' => 'app.events.index',
                    ],
                    [
                        'key' => '3-2',
                        'title' => 'Tambah Acara',
                        'route' => 'app.events.create',
                    ],
                ],
            ],
            [
                'key' => '4',
                'title' => 'Modul Pembelajaran',
                'icon' => 'BookOutlined',
                'children' => [
                    [
                        'key' => '4-1',
                        'title' => 'Daftar Modul',
                        'route' => 'app.learnings.index',
                    ],
                    [
                        'key' => '4-2',
                        'title' => 'Tambah Modul',
                        'route' => 'app.learnings.create',
                    ],
                ],
            ],
            [
                'key' => '5',
                'title' => 'Jadwal Pengangkutan',
                'icon' => 'CarOutlined',
                'route' => 'app.pickup-schedules.index',
            ],
            [
                'key' => '6',
                'title' => 'Manajemen Sampah',
                'icon' => 'FolderOpenOutlined',
                'children' => [
                    [
                        'key' => '6-1',
                        'title' => 'Kategori',
                        'route' => 'app.waste-categories.index',
                    ],
                    [
                        'key' => '6-2',
                        'title' => 'Item',
                        'route' => 'app.waste-items.index',
                    ],
                    [
                        'key' => '6-3',
                        'title' => 'Laporan',
                        'route' => 'app.waste-reports.index',
                    ],
                    [
                        'key' => '6-4',
                        'title' => 'Lokasi',
                        'route' => 'app.waste-locations.index',
                    ],
                ],
            ],
            [
                'key' => '7',
                'title' => 'Manajemen Beranda',
                'icon' => 'HomeOutlined',
                'children' => [
                    [
                        'key' => '7-1',
                        'title' => 'Slider',
                        'route' => 'app.sliders.index',
                    ],
                    [
                        'key' => '7-2',
                        'title' => 'FAQ',
                        'route' => 'app.faqs.index',
                    ],
                    [
                        'key' => '7-3',
                        'title' => ' Pesan Kontak',
                        'route' => 'app.contacts.index',
                    ],
                ],
            ],
            [
                'key' => '8',
                'title' => 'Pengguna',
                'icon' => 'UserOutlined',
                'children' => [
                    [
                        'key' => '8-1',
                        'title' => 'Daftar Pengguna',
                        'route' => 'app.users.index',
                    ],
                    [
                        'key' => '8-2',
                        'title' => 'Tambah Pengguna',
                        'route' => 'app.users.create',
                    ],
                    [
                        'key' => '8-3',
                        'title' => 'Daftar Peran',
                        'route' => 'app.roles.index',
                    ],
                ],
            ],
        ];
    }

    private function getCitizenMenu(): array
    {
        return [
            [
                'key' => '1',
                'title' => 'Dasboard',
                'icon' => 'DashboardOutlined',
                'route' => 'app.dashboard',
            ],
            // [
            //     'key' => '2',
            //     'title' => 'Sampah Saya',
            //     'icon' => 'AuditOutlined',
            //     'route' => 'app.waste-sorting.index',
            // ],
            [
                'key' => '3',
                'title' => 'Modul Pembelajaran',
                'icon' => 'BookOutlined',
                'route' => 'app.learnings.index',
            ],
            [
                'key' => '4',
                'title' => 'Jadwal Pengangkutan',
                'icon' => 'CarOutlined',
                'route' => 'app.pickup-schedules.index',
            ],
            [
                'key' => '5',
                'title' => 'Wilayah',
                'icon' => 'EnvironmentOutlined',
                'route' => 'app.waste-locations.location',
            ],
            [
                'key' => '6',
                'title' => 'Pelaporan Sampah',
                'icon' => 'FormOutlined',
                'route' => 'app.waste-reports.index',
            ],
            [
                'key' => '7',
                'title' => 'Pengingat Sampah',
                'icon' => 'ClockCircleOutlined',
                'route' => 'app.waste-reminders.index',
            ],
            [
                'title' => 'Acara',
                'icon' => 'CalendarOutlined',
                'children' => [
                    [
                        'key' => '8-1',
                        'title' => 'Daftar Event',
                        'route' => 'app.events.index',
                    ],
                    [
                        'key' => '8-2',
                        'title' => 'Partisipasi Acara',
                        'route' => 'app.event-participants.index',
                    ],
                ],
            ],
        ];
    }

    private function getOfficerMenu(): array
    {
        return [
            [
                'key' => '1',
                'title' => 'Dasboard',
                'icon' => 'DashboardOutlined',
                'route' => 'app.dashboard',
            ],
            [
                'key' => '2',
                'title' => 'Jadwal Pengangkutan',
                'icon' => 'CarOutlined',
                'route' => 'app.pickup-schedules.index',
            ],
            [
                'key' => '3',
                'title' => 'Riwayat Pengangkutan',
                'icon' => 'BookOutlined',
                'route' => 'app.pickup-schedules.history',
            ],
        ];
    }

    private function getGovernmentMenu(): array
    {
        return [
            [
                'key' => '1',
                'title' => 'Dasboard',
                'icon' => 'DashboardOutlined',
                'route' => 'app.dashboard',
            ],
            [
                'key' => '2',
                'title' => 'Jadwal Pengangkutan',
                'icon' => 'CarOutlined',
                'route' => 'app.pickup-schedules.index',
            ],
            [
                'key' => '3',
                'title' => 'Modul Pembelajaran',
                'icon' => 'BookOutlined',
                'children' => [
                    [
                        'key' => '3-1',
                        'title' => 'Daftar Modul',
                        'route' => 'app.learnings.index',
                    ],
                    [
                        'key' => '3-2',
                        'title' => 'Tambah Modul',
                        'route' => 'app.learnings.create',
                    ],
                ],
            ],
            [
                'key' => '4',
                'title' => 'Manajemen Event',
                'icon' => 'CalendarOutlined',
                'children' => [
                    [
                        'key' => '4-1',
                        'title' => 'Daftar Acara',
                        'route' => 'app.events.index',
                    ],
                    [
                        'key' => '4-2',
                        'title' => 'Tambah Acara',
                        'route' => 'app.events.create',
                    ],
                ],
                [
                    'key' => '5',
                    'title' => 'Verifikasi Laporan',
                    'icon' => 'DashboardOutlined',
                    'route' => 'app.dashboard',
                ],
            ],
        ];
    }

    private function getGuestMenu(): array
    {
        return [];
    }
}