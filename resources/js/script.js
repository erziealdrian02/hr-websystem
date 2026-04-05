// Dark Mode Logic
const themeToggleBtn = document.getElementById('theme-toggle');
const html = document.documentElement;

// Check LocalStorage or system preference
if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    html.classList.add('dark');
} else {
    html.classList.remove('dark');
}

function toggleTheme() {
    if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    }
}

// Delegate events if injected dynamically or naturally
document.addEventListener('click', function(e) {
    if(e.target.closest('#theme-toggle')) {
        toggleTheme();
    }
    
    // Sidebar toggle for mobile (both sidebar button and header button)
    if(e.target.closest('#sidebar-toggle') || e.target.closest('#sidebar-toggle-header')) {
        const sidebar = document.getElementById('sidebar');
        if(sidebar) {
            sidebar.classList.toggle('-translate-x-full');
        }
    }
});

// Realtime Clock logic for Dashboard and Attendance
function updateClock() {
    const clockElements = document.querySelectorAll('.realtime-clock');
    if (clockElements.length > 0) {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        const dateStr = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        clockElements.forEach(el => {
            el.querySelector('.time-display').innerText = timeStr;
            el.querySelector('.date-display').innerText = dateStr;
        });
    }
}

setInterval(updateClock, 1000);
document.addEventListener('DOMContentLoaded', updateClock);
