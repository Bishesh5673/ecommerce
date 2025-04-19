<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SellerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('seller')
            ->path('seller')
            ->login()
            ->authGuard('seller')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Seller/Resources'), for: 'App\\Filament\\Seller\\Resources')
            ->discoverPages(in: app_path('Filament/Seller/Pages'), for: 'App\\Filament\\Seller\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Seller/Widgets'), for: 'App\\Filament\\Seller\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])

            ->renderHook('panels::body.end', function () {
                $soundUrl = asset('sounds/notification.mp3');

                return <<<HTML
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        let audioCtx;
                        let isUnlocked = false;
                        let notificationAudio = new Audio("{$soundUrl}");

                        async function unlockAudioContextAndPlay() {
                            try {
                                if (!audioCtx) {
                                    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                                    const buffer = audioCtx.createBuffer(1, 1, 22050);
                                    const source = audioCtx.createBufferSource();
                                    source.buffer = buffer;
                                    source.connect(audioCtx.destination);
                                    source.start(0);
                                }

                                isUnlocked = true;
                                console.log("✅ AudioContext unlocked");
                                document.getElementById("enable-sound-btn")?.remove();

                                // Ask notification permission
                                if (Notification.permission !== "granted") {
                                    Notification.requestPermission().then(p => {
                                        console.log("🔔 Notification permission:", p);
                                    });
                                }
                            } catch (err) {
                                console.warn("Unlock failed:", err);
                            }
                        }

                        function playNotificationSound() {
                            if (!isUnlocked || !audioCtx || audioCtx.state !== 'running') {
                                console.warn("⚠️ AudioContext not unlocked or suspended.");
                                return;
                            }

                            const audio = new Audio("{$soundUrl}");
                            audio.play().then(() => {
                                console.log("🔊 Notification sound played.");
                            }).catch(err => {
                                console.error("❌ Failed to play sound:", err);
                            });
                        }

                        function showDesktopNotification() {
                            if (Notification.permission === "granted") {
                                const notification = new Notification("🛒 New Order Received", {
                                    body: "A new order just arrived!",
                                    icon: "/favicon.ico",
                                    silent: true // prevents double sound if browser adds default chime
                                });

                                notification.onclick = () => {
                                    window.focus();
                                };
                            }
                        }

                        // Create and show enable button
                        const enableBtn = document.createElement("button");
                        enableBtn.id = "enable-sound-btn";
                        enableBtn.textContent = "Enable Sound Notification";
                        Object.assign(enableBtn.style, {
                            position: "fixed",
                            bottom: "20px",
                            right: "20px",
                            zIndex: "9999",
                            padding: "10px 16px",
                            backgroundColor: "#06b6d4",
                            color: "#fff",
                            border: "none",
                            borderRadius: "8px",
                            cursor: "pointer",
                            boxShadow: "0 2px 4px rgba(0, 0, 0, 0.2)"
                        });
                        document.body.appendChild(enableBtn);

                        enableBtn.addEventListener("click", unlockAudioContextAndPlay);

                        document.addEventListener("livewire:init", () => {
                            Livewire.on("play-sound", () => {
                                console.log("🔔 play-sound triggered");
                                playNotificationSound();
                                showDesktopNotification();
                            });
                        });
                    });
                </script>
                HTML;
            });
    }
}
