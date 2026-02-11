<div id="pwa-install-prompt" class="fixed bottom-20 left-4 right-4 md:left-auto md:right-8 md:bottom-8 z-[60] hidden">
    <div class="bg-white rounded-2xl shadow-2xl p-6 border border-gray-200 max-w-sm transform transition-all duration-300 scale-95 opacity-0" id="pwa-modal">
        <div class="flex items-start gap-4">
            <div class="bg-red-100 p-3 rounded-xl flex-shrink-0">
                <img src="/images/logo.png" alt="App Icon" class="w-12 h-12 rounded-full shadow-sm">
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900">Instal Aplikasi</h3>
                <p class="text-gray-600 text-sm mt-1 leading-relaxed">
                    Instal aplikasi LSM Harimau di perangkat Anda untuk akses lebih cepat dan mudah.
                </p>
            </div>
            <button onclick="hidePwaPrompt()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="mt-6 flex gap-3">
            <button onclick="hidePwaPrompt()" class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                Nanti Saja
            </button>
            <button id="install-button" class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-lg shadow-red-200 transition">
                Instal Sekarang
            </button>
        </div>
    </div>
</div>

<script>
    let deferredPrompt;
    const pwaPrompt = document.getElementById('pwa-install-prompt');
    const pwaModal = document.getElementById('pwa-modal');
    const installButton = document.getElementById('install-button');

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        
        // Only show if not already dismissed in this session
        if (!sessionStorage.getItem('pwa-prompt-dismissed')) {
            showPwaPrompt();
        }
    });

    function showPwaPrompt() {
        pwaPrompt.classList.remove('hidden');
        setTimeout(() => {
            pwaModal.classList.remove('scale-95', 'opacity-0');
            pwaModal.classList.add('scale-100', 'opacity-100');
        }, 100);
    }

    function hidePwaPrompt() {
        pwaModal.classList.remove('scale-100', 'opacity-100');
        pwaModal.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            pwaPrompt.classList.add('hidden');
            sessionStorage.setItem('pwa-prompt-dismissed', 'true');
        }, 300);
    }

    installButton.addEventListener('click', (e) => {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                } else {
                    console.log('User dismissed the A2HS prompt');
                }
                deferredPrompt = null;
                hidePwaPrompt();
            });
        }
    });

    window.addEventListener('appinstalled', (evt) => {
        console.log('PWA was installed');
        hidePwaPrompt();
    });

    // Register Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(reg => console.log('Service Worker registered', reg))
                .catch(err => console.log('Service Worker registration failed', err));
        });
    }
</script>