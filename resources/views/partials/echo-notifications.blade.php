@if(auth()->check())
    window.addEventListener('load', () => {
        if (window.Echo) {
            const canAutoReload = @json($canAutoReload ?? []);
            const shouldAutoReload = canAutoReload.some((patternStr) => {
                const pattern = new RegExp(patternStr);
                return pattern.test(window.location.pathname);
            });

            window.Echo.private('App.Models.User.' + {{ auth()->id() }})
                .notification((notification) => {
                    const notifData = notification.data || notification;
                    
                    if (window.showToast) {
                        window.showToast(notifData.title || 'Notifikasi Baru', 'success', true);
                    }

                    const reloadableTypes = @json($reloadableTypes ?? []);
                    const isReloadable = reloadableTypes.includes(notifData.event_type);
                    const autoRedirect = @json($autoRedirect ?? false);

                    if (shouldAutoReload && isReloadable && !window.__globalNotifReloadScheduled) {
                        window.__globalNotifReloadScheduled = true;
                        
                        if (autoRedirect) {
                            const targetLink = notifData.link;
                            if (targetLink) {
                                const targetUrl = new URL(targetLink, window.location.origin);
                                if (targetUrl.pathname !== window.location.pathname || targetUrl.search !== window.location.search) {
                                    setTimeout(() => window.location.href = targetUrl.toString(), 250);
                                    return;
                                }
                            }
                        }
                        
                        setTimeout(() => window.location.reload(), 600);
                    }
                });
        }
    });
@endif
