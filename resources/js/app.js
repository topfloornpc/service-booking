import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
console.log('APP.JS LOADED', new Date().toISOString());


document.addEventListener('DOMContentLoaded', () => {
    const cityInput = document.getElementById('weather-city');
    const btn = document.getElementById('weather-btn');
    const out = document.getElementById('weather-out');

    if (!cityInput || !btn || !out) return;

    const hasValidTemp = (temp) => {
        // Treat null/undefined/empty/"—" as missing
        if (temp === null || temp === undefined) return false;

        // Sometimes UI placeholders come as strings like "—" or "null"
        if (typeof temp === 'string') {
            const t = temp.trim();
            if (!t || t === '—' || t.toLowerCase() === 'null') return false;
            const n = Number(t.replace(',', '.'));
            return Number.isFinite(n);
        }

        // Numbers
        return Number.isFinite(temp);
    };

    const formatTemp = (temp) => {
        if (typeof temp === 'number') return temp;
        const n = Number(String(temp).trim().replace(',', '.'));
        return Number.isFinite(n) ? n : null;
    };

    const render = (data, fallbackCity) => {
        const city = (data && data.city) ? data.city : (fallbackCity || 'Unknown city');

        if (!data || !hasValidTemp(data.temp)) {
            out.textContent = `Weather in ${city} is currently unavailable.`;
            out.className = 'mt-2 text-sm text-gray-700';
            return;
        }

        const t = formatTemp(data.temp);
        out.textContent = `Weather in ${city}: ${t}°C, ${data.desc ?? ''}`.trim();
        out.className = 'mt-2 text-sm text-gray-700';
    };

    btn.addEventListener('click', async (e) => {
        // If the button is inside a <form>, prevent page reload
        e.preventDefault();

        const city = (cityInput.value || 'Riga').trim();
        out.textContent = 'Loading...';
        out.className = 'mt-2 text-sm text-gray-600';

        try {
            const res = await fetch(`/api/weather?city=${encodeURIComponent(city)}`, {
                headers: { 'Accept': 'application/json' },
            });

            if (!res.ok) {
                render(null, city);
                return;
            }

            const data = await res.json();
            render(data, city);
        } catch {
            render(null, city);
        }
    });
});
