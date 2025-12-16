    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div>
                    <h3>Imperial Turistik</h3>
                    <p>Туристическая компания с 1998 года</p>
                    <p>imperial.turistik@gmail.com</p>
                </div>
                <div>
                    <h3>Контакты</h3>
                    <p>+7 999 999 99 99</p>
                    <p>ул. Пушкина д 12</p>
                </div>
                <div>
                    <h3>Ссылки</h3>
                    <a href="tours.php">Туры</a><br>
                    <a href="countries.php">Страны</a><br>
                    <a href="contacts.php">Контакты</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Модальное окно
        function openModal() {
            document.getElementById('bookModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('bookModal').style.display = 'none';
        }
        
        // Отправка формы
        document.getElementById('bookingForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Заявка отправлена!');
            closeModal();
        });
    </script>
</body>
</html>