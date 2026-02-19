<!-- 🎯 السكريبتات الأساسية -->
<script>
    // القائمة المتنقلة
    document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });

    // إغلاق القائمة عند النقر خارجها
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobile-menu');
        const menuBtn = document.getElementById('mobile-menu-btn');
        
        if (menu && menuBtn && !menu.contains(event.target) && !menuBtn.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

    // تأثيرات التحميل
    document.addEventListener('DOMContentLoaded', function() {
        // إضافة تأثير fade-in للعناصر
        const elements = document.querySelectorAll('.fade-in');
        elements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                el.style.transition = 'all 0.6s ease';
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, 100);
        });

        // إضافة active class للروابط النشطة
        const currentPath = window.location.pathname;
        document.querySelectorAll('nav a').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('text-white', 'font-semibold');
                link.classList.remove('hover:text-white/80');
            }
        });
    });

    // عرض رسائل التنبيه بشكل جميل
    @if(session()->has('success'))
    setTimeout(() => {
        showNotification('{{ session('success') }}', 'success');
    }, 500);
    @endif

    @if(session()->has('error'))
    setTimeout(() => {
        showNotification('{{ session('error') }}', 'error');
    }, 500);
    @endif

    @if(session()->has('warning'))
    setTimeout(() => {
        showNotification('{{ session('warning') }}', 'warning');
    }, 500);
    @endif

    @if(session()->has('info'))
    setTimeout(() => {
        showNotification('{{ session('info') }}', 'info');
    }, 500);
    @endif

    function showNotification(message, type) {
        const notification = document.createElement('div');
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };
        
        const colors = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-white',
            info: 'bg-blue-500 text-white'
        };
        
        notification.className = `fixed top-4 left-4 right-4 md:left-auto md:right-4 md:max-w-sm z-50 p-4 rounded-lg shadow-lg transform transition-transform duration-300 ${colors[type]}`;
        notification.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="${icons[type]}"></i>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="hover:opacity-70 transition-opacity">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        document.body.appendChild(notification);
        
        // إزالة التنبيه تلقائياً بعد 5 ثواني
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    // وظيفة مساعدة للتحقق من العناصر
    function elementExists(selector) {
        return document.querySelector(selector) !== null;
    }

    // منع إرسال النماذج المزدوجة
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري المعالجة...';
                    
                    // إعادة تمكين الزر بعد 10 ثواني (في حالة error)
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = submitBtn.getAttribute('data-original-text') || 'إرسال';
                    }, 10000);
                }
            });
        });
    });

    // تحسين تجربة التمرير
    document.documentElement.style.scrollBehavior = 'smooth';

    // تحسين الأداء للصور
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.loading = 'lazy';
        });
    });

    // إدارة حالة التحميل
    window.showLoading = function() {
        const loader = document.createElement('div');
        loader.id = 'global-loader';
        loader.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
        loader.innerHTML = `
            <div class="bg-white p-6 rounded-xl shadow-2xl flex items-center gap-3">
                <i class="fas fa-spinner fa-spin text-blue-600 text-xl"></i>
                <span class="text-gray-700 font-semibold">جاري التحميل...</span>
            </div>
        `;
        document.body.appendChild(loader);
    };

    window.hideLoading = function() {
        const loader = document.getElementById('global-loader');
        if (loader) {
            loader.remove();
        }
    };

    // معالجة الأخطاء العامة
    window.addEventListener('error', function(e) {
        console.error('حدث خطأ:', e.error);
        showNotification('حدث خطأ غير متوقع. يرجى تحديث الصفحة.', 'error');
    });

    // تحسين أداء الرسوم المتحركة
    window.requestAnimationFrame(() => {
        // تهيئة أي رسوم متحركة هنا
    });
</script>

<!-- 🎯 السكريبتات الإضافية للـ Livewire -->
@if(config('app.debug'))
<script>
    // تفعيل وضع التصحيح في التطوير
    console.log('🚀 استبياني - وضع التطوير نشط');
    
    // مراقبة أحداث Livewire
    window.addEventListener('livewire:load', function() {
        console.log('✅ Livewire loaded successfully');
    });
    
    window.addEventListener('livewire:update', function() {
        console.log('🔄 Livewire DOM updated');
    });
    
    window.addEventListener('livewire:error', function(e) {
        console.error('❌ Livewire error:', e.detail);
    });
</script>
@endif