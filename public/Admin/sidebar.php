   <aside class="sidebar">
        <nav class="sidebar-menu">
            <div class="menu-item">
                <a href="index.php" class="menu-link active">
                    <i class="fas fa-tachometer-alt menu-icon"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="/Users/dashboard.php" class="menu-link">
                    <i class="fas fa-cash-register menu-icon"></i>
                    <span class="menu-text">POS</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="customer_order.php" class="menu-link">
                    <i class="fas fa-shopping-cart menu-icon"></i>
                    <span class="menu-text">Customer Order</span>
                    <span class="menu-badge">5</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="productlist.php" class="menu-link">
                    <i class="fas fa-box menu-icon"></i>
                    <span class="menu-text">Products</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="#" class="menu-link has-submenu" onclick="toggleSubmenu(this)">
                    <i class="fas fa-drumstick-bite menu-icon"></i>
                    <span class="menu-text">Chickens</span>
                    <i class="fas fa-chevron-down menu-arrow"></i>
                </a>
                <div class="submenu">
                    <a href="chicken_batchwise.php" class="submenu-link">Chickens BatchWise</a>
                    <a  href="chicken_entries.php" class="submenu-link">Chickens Daily Entries</a>
                </div>
            </div>

            <div class="menu-item">
                <a href="eggProduction.php" class="menu-link">
                    <i class="fas fa-egg menu-icon"></i>
                    <span class="menu-text">Egg Production</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="Users.php" class="menu-link">
                    <i class="fas fa-users menu-icon"></i>
                    <span class="menu-text">Users</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="expnsenses.php" class="menu-link">
                    <i class="fas fa-receipt menu-icon"></i>
                    <span class="menu-text">Expenses</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="CustomerSubmissions.php" class="menu-link">
                    <i class="fas fa-clipboard-list menu-icon"></i>
                    <span class="menu-text">Customer Submissions</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="report.php" class="menu-link">
                    <i class="fas fa-chart-bar menu-icon"></i>
                    <span class="menu-text">Reports</span>
                </a>
            </div>
        </nav>
    </aside>


    
    <script>
        function toggleSubmenu(element) {
            const submenu = element.nextElementSibling;
            const arrow = element.querySelector('.menu-arrow');
            
            // Close all other submenus
            document.querySelectorAll('.submenu.active').forEach(menu => {
                if (menu !== submenu) {
                    menu.classList.remove('active');
                    menu.previousElementSibling.classList.remove('active');
                }
            });
            
            // Toggle current submenu
            submenu.classList.toggle('active');
            element.classList.toggle('active');
        }

     

        
        // Add some interactive effects
        document.querySelectorAll('.menu-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(8px)';
            });
            
            link.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateX(0)';
                }
            });
        });

           function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('active');
        }


        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('userDropdown');
            
            if (!userMenu.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });
    </script>