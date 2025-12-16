// Основной JavaScript файл

document.addEventListener('DOMContentLoaded', function() {
    // Модальное окно для заявки
    const modal = document.getElementById('bookModal');
    const bookingForm = document.getElementById('bookingForm');
    const openModalButtons = document.querySelectorAll('.open-modal');
    const closeModalButton = document.querySelector('.close-modal');
    
    // Открытие модального окна
    openModalButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Блокируем прокрутку
        });
    });
    
    // Закрытие модального окна
    if (closeModalButton) {
        closeModalButton.addEventListener('click', function() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    }
    
    // Закрытие по клику вне окна
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
    
    // Закрытие по ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
    
    // Отправка формы заявки
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Показываем индикатор загрузки
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Отправка...';
            submitBtn.disabled = true;
            
            fetch('book_ajax.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.');
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                    bookingForm.reset();
                } else {
                    alert('Ошибка: ' + data.message);
                }
            })
            .catch(error => {
                alert('Ошибка сети. Пожалуйста, попробуйте позже.');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }
    
    // Слайдер на главной
    const slider = document.querySelector('.slider');
    if (slider) {
        const slides = document.querySelector('.slides');
        const prevBtn = document.getElementById('prevSlide');
        const nextBtn = document.getElementById('nextSlide');
        
        if (slides && prevBtn && nextBtn) {
            let currentSlide = 0;
            const totalSlides = slides.children.length;
            
            function updateSlider() {
                slides.style.transform = `translateX(-${currentSlide * 100}%)`;
            }
            
            prevBtn.addEventListener('click', function() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSlider();
                resetAutoSlide();
            });
            
            nextBtn.addEventListener('click', function() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
                resetAutoSlide();
            });
            
            // Автоматическая смена слайдов
            let autoSlideInterval = setInterval(autoSlide, 5000);
            
            function autoSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }
            
            function resetAutoSlide() {
                clearInterval(autoSlideInterval);
                autoSlideInterval = setInterval(autoSlide, 5000);
            }
            
            // Пауза при наведении
            slider.addEventListener('mouseenter', () => {
                clearInterval(autoSlideInterval);
            });
            
            slider.addEventListener('mouseleave', () => {
                autoSlideInterval = setInterval(autoSlide, 5000);
            });
        }
    }
    
    // Валидация форм
    const forms = document.querySelectorAll('form:not(#bookingForm)');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            let firstInvalidField = null;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#ff4444';
                    
                    // Анимация для первого невалидного поля
                    if (!firstInvalidField) {
                        firstInvalidField = field;
                        field.style.animation = 'shake 0.5s ease';
                        setTimeout(() => {
                            field.style.animation = '';
                        }, 500);
                    }
                } else {
                    field.style.borderColor = '#ddd';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                
                if (firstInvalidField) {
                    firstInvalidField.focus();
                }
                
                // Показываем сообщение об ошибке
                const existingError = this.querySelector('.form-error');
                if (existingError) {
                    existingError.remove();
                }
                
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger form-error mt-2';
                errorDiv.textContent = 'Пожалуйста, заполните все обязательные поля';
                this.insertBefore(errorDiv, this.firstChild);
            }
        });
    });
    
    // Анимация для полей формы
    const formInputs = document.querySelectorAll('input, textarea, select');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
    
    // Плавная прокрутка для якорных ссылок
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#' || targetId === '#/') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Подсветка активной страницы в навигации
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.nav-links a');
    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href');
        if (linkHref === currentPage) {
            link.classList.add('active');
        }
    });
    
    // Анимация карточек при прокрутке
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.card').forEach(card => {
        observer.observe(card);
    });
    
    // Анимация для fade-in
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }
        
        .form-group.focused .form-label {
            color: #065EE3;
            font-weight: bold;
        }
    `;
    document.head.appendChild(style);
    
    // Обработка телефонного номера
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            
            if (value.length > 0) {
                if (value[0] === '7' || value[0] === '8') {
                    value = value.substring(1);
                }
                
                let formattedValue = '+7';
                
                if (value.length > 0) {
                    formattedValue += ' (' + value.substring(0, 3);
                }
                if (value.length > 3) {
                    formattedValue += ') ' + value.substring(3, 6);
                }
                if (value.length > 6) {
                    formattedValue += '-' + value.substring(6, 8);
                }
                if (value.length > 8) {
                    formattedValue += '-' + value.substring(8, 10);
                }
                
                this.value = formattedValue;
            }
        });
    });
    
    // Кнопка "Наверх"
    const scrollToTopBtn = document.createElement('button');
    scrollToTopBtn.innerHTML = '↑';
    scrollToTopBtn.className = 'scroll-to-top';
    scrollToTopBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #065EE3;
        color: white;
        border: none;
        font-size: 20px;
        cursor: pointer;
        display: none;
        z-index: 99;
        box-shadow: 0 4px 15px rgba(6, 94, 227, 0.3);
        transition: all 0.3s;
    `;
    
    scrollToTopBtn.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.1)';
        this.style.boxShadow = '0 6px 20px rgba(6, 94, 227, 0.4)';
    });
    
    scrollToTopBtn.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
        this.style.boxShadow = '0 4px 15px rgba(6, 94, 227, 0.3)';
    });
    
    scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    document.body.appendChild(scrollToTopBtn);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.style.display = 'block';
        } else {
            scrollToTopBtn.style.display = 'none';
        }
    });
});