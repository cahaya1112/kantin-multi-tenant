<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <div class="p-6">
                    <h3 class="text-lg font-semibold">Admin Dashboard</h3>
                    <p class="text-sm text-neutral-500">Selamat datang di Dashboard Admin Kantin Multi-Tenant!</p>
                </div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"></div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"></div>
        </div>
        <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min"></div>
    </div>
</x-layouts.app>php artisan route:list