<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chicken Batch Entry System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #16a085 0%, #f4d03f 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #148f77, #16a085);
            color: white;
            text-align: center;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            z-index: 1;
            position: relative;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            z-index: 1;
            position: relative;
        }

        .form-section {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 1rem;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        input[type="date"], input[type="number"] {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        input[type="date"]:focus, input[type="number"]:focus {
            outline: none;
            border-color: #16a085;
            background: white;
            box-shadow: 0 0 0 4px rgba(22, 160, 133, 0.1);
            transform: translateY(-2px);
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .btn-save {
            background: linear-gradient(135deg, #148f77, #16a085);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(22, 160, 133, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(22, 160, 133, 0.4);
        }

        .btn-save:active {
            transform: translateY(-1px);
        }

        .btn-save::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-save:hover::before {
            left: 100%;
        }

        .entries-section {
            padding: 0 40px 40px;
        }

        .entries-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e1e5e9;
        }

        .entries-header h3 {
            color: #333;
            font-size: 1.5rem;
        }

        .entries-count {
            background: linear-gradient(135deg, #f4d03f, #f1c40f);
            color: #333;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .entry-item {
            background: linear-gradient(135deg, #16a085 0%, #148f77 100%);
            color: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 20px rgba(22, 160, 133, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .entry-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(22, 160, 133, 0.4);
        }

        .entry-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
            pointer-events: none;
        }

        .entry-info {
            z-index: 1;
        }

        .entry-date {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .entry-quantity {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .delete-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 1;
        }

        .delete-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .form-section, .entries-section {
                padding: 20px;
            }
            
            .entry-item {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🐔 Chicken Batch Entry</h1>
            <p>Track your poultry arrivals with precision</p>
        </div>
        
        <div class="form-section">
            <form id="batchForm">
                <div class="form-group">
                    <label for="arrivalDate">Arrival Date</label>
                    <input type="date" id="arrivalDate" name="arrivalDate" required>
                </div>
                
                <div class="form-group">
                    <label for="quantity">Quantity (Birds)</label>
                    <input type="number" id="quantity" name="quantity" placeholder="Enter number of chickens" min="1" required>
                </div>
                
                <button type="submit" class="btn-save">Save Entry</button>
            </form>
        </div>
        
        <div class="entries-section">
            <div class="entries-header">
                <h3>Recent Entries</h3>
                <div class="entries-count" id="entriesCount">0 Batches</div>
            </div>
            
            <div id="entriesList">
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <h4>No entries yet</h4>
                    <p>Start by adding your first chicken batch entry above</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let entries = [];
        
        const form = document.getElementById('batchForm');
        const entriesList = document.getElementById('entriesList');
        const entriesCount = document.getElementById('entriesCount');
        
        // Set today's date as default
        document.getElementById('arrivalDate').value = new Date().toISOString().split('T')[0];
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const arrivalDate = document.getElementById('arrivalDate').value;
            const quantity = parseInt(document.getElementById('quantity').value);
            
            if (!arrivalDate || !quantity || quantity <= 0) {
                alert('Please fill in all fields with valid values.');
                return;
            }
            
            const entry = {
                id: Date.now(),
                date: arrivalDate,
                quantity: quantity,
                timestamp: new Date()
            };
            
            entries.unshift(entry);
            renderEntries();
            form.reset();
            document.getElementById('arrivalDate').value = new Date().toISOString().split('T')[0];
            
            // Show success animation
            const saveBtn = document.querySelector('.btn-save');
            const originalText = saveBtn.textContent;
            saveBtn.textContent = '✓ Saved!';
            saveBtn.style.background = 'linear-gradient(135deg, #27ae60, #2ecc71)';
            
            setTimeout(() => {
                saveBtn.textContent = originalText;
                saveBtn.style.background = 'linear-gradient(135deg, #148f77, #16a085)';
            }, 2000);
        });
        
        function renderEntries() {
            const totalBatches = entries.length;
            const totalQuantity = entries.reduce((sum, entry) => sum + entry.quantity, 0);
            entriesCount.textContent = `${totalBatches} Batches (${totalQuantity.toLocaleString()} Birds)`;
            
            if (entries.length === 0) {
                entriesList.innerHTML = `
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <h4>No entries yet</h4>
                        <p>Start by adding your first chicken batch entry above</p>
                    </div>
                `;
                return;
            }
            
            entriesList.innerHTML = entries.map(entry => `
                <div class="entry-item">
                    <div class="entry-info">
                        <div class="entry-date">${formatDate(entry.date)}</div>
                        <div class="entry-quantity">${entry.quantity.toLocaleString()} Birds</div>
                    </div>
                    <button class="delete-btn" onclick="deleteEntry(${entry.id})" title="Delete entry">
                        ×
                    </button>
                </div>
            `).join('');
        }
        
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }
        
        function deleteEntry(id) {
            if (confirm('Are you sure you want to delete this entry?')) {
                entries = entries.filter(entry => entry.id !== id);
                renderEntries();
            }
        }
        
        // Initialize
        renderEntries();
    </script>
</body>
</html>