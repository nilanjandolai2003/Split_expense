<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Expense Splitter</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 3rem;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-weight: 500;
            animation: slideIn 0.3s ease-out;
            display: block;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert.success {
            background: #f0fdf4;
            color: #15803d;
            border-left: 4px solid #22c55e;
        }

        .alert.error {
            background: #fef2f2;
            color: #b91c1c;
            border-left: 4px solid #ef4444;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #cbd5e1;
        }

        .btn {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            width: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-delete {
            background: #ef4444;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            width: auto;
        }

        .btn-delete:hover {
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
        }

        .groups-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }

        .group-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.4s ease-out;
        }

        .group-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .group-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1a202c;
        }

        .group-stats {
            display: flex;
            gap: 1rem;
            margin: 1rem 0;
            font-size: 0.9rem;
        }

        .stat {
            background: #f8fafc;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            color: #718096;
        }

        .stat-value {
            font-weight: 600;
            color: #667eea;
        }

        .members-list {
            margin: 1rem 0;
        }

        .members-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #a0aec0;
            margin-bottom: 0.5rem;
        }

        .member-tag {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .transactions-section {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid #e2e8f0;
        }

        .transaction-item {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
        }

        .transaction-from {
            font-weight: 600;
            color: #b91c1c;
        }

        .transaction-to {
            font-weight: 600;
            color: #15803d;
        }

        .transaction-amount {
            margin-left: auto;
            background: #fef3c7;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 600;
            color: #92400e;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #a0aec0;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .tab {
            padding: 1rem;
            background: none;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            color: #a0aec0;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }

        .tab.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .expenses-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .expense-item {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 0.75rem;
            display: grid;
            grid-template-columns: 1fr auto auto;
            align-items: center;
            gap: 1rem;
            font-size: 0.95rem;
        }

        .expense-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .expense-description {
            font-weight: 600;
            color: #1a202c;
        }

        .expense-payer {
            font-size: 0.85rem;
            color: #718096;
        }

        .expense-amount {
            background: #dbeafe;
            color: #1e40af;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-height: 200px;
            overflow-y: auto;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            background: #f8fafc;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .checkbox-item:hover {
            background: #dbeafe;
        }

        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            max-width: 500px;
            width: 100%;
            padding: 2rem;
            animation: slideUp 0.3s ease-out;
        }

        .modal-header {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 1.5rem;
        }

        .modal-footer {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn-cancel {
            background: #e2e8f0;
            color: #2d3748;
        }

        .btn-cancel:hover {
            background: #cbd5e1;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
            .groups-grid {
                grid-template-columns: 1fr;
            }
            .header h1 {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>💰 Smart Expense Splitter</h1>
        <p>Split expenses smartly with minimum transactions</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert <?= htmlspecialchars($message['type'], ENT_QUOTES) ?>">
            <?= htmlspecialchars($message['text'], ENT_QUOTES) ?>
        </div>
    <?php endif; ?>

    <div class="grid">
        <!-- Create Group Section -->
        <div class="section">
            <h2>➕ Create Group</h2>
            <form method="post" action="/group/create">
                <div class="form-group">
                    <label for="group_name">Group Name</label>
                    <input type="text" id="group_name" name="name" placeholder="e.g., Roommates, Vacation Trip" required>
                </div>
                <div class="form-group">
                    <label for="description">Description (Optional)</label>
                    <textarea id="description" name="description" placeholder="Add notes about this group..."></textarea>
                </div>
                <button type="submit" class="btn">Create Group</button>
            </form>
        </div>

        <!-- Quick Add Expense Section -->
        <div class="section">
            <h2>🧾 Add Expense</h2>
            <?php if (!empty($groupDetails)): ?>
                <form method="post" action="/expense/create" id="expenseForm">
                    <div class="form-group">
                        <label for="group_id">Select Group</label>
                        <select name="group_id" id="group_id" required style="width: 100%; padding: 0.875rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem; font-family: inherit;">
                            <option value="">-- Choose a group --</option>
                            <?php foreach ($groupDetails as $gd): ?>
                                <option value="<?= htmlspecialchars($gd['group']['id'], ENT_QUOTES) ?>">
                                    <?= htmlspecialchars($gd['group']['name'], ENT_QUOTES) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="expense_desc">Description</label>
                        <input type="text" id="expense_desc" name="description" placeholder="e.g., Dinner, Gas, Movie tickets" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" id="amount" name="amount" step="0.01" min="0" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label for="paid_by">Paid By</label>
                        <input type="text" id="paid_by" name="paid_by" placeholder="Your name" required>
                    </div>
                    <div class="form-group">
                        <label>Split With</label>
                        <div id="splitWithContainer" class="checkbox-group">
                            <p style="color: #a0aec0; text-align: center;">Select a group first</p>
                        </div>
                    </div>
                    <button type="submit" class="btn">Add Expense</button>
                </form>
            <?php else: ?>
                <p style="color: #a0aec0; text-align: center;">Create a group first to add expenses</p>
            <?php endif; ?>
        </div>

        <!-- Add Member Section -->
        <div class="section">
            <h2>👥 Add Group Member</h2>
            <?php if (!empty($groupDetails)): ?>
                <form method="post" action="/group/add-member">
                    <div class="form-group">
                        <label for="member_group_id">Select Group</label>
                        <select name="group_id" id="member_group_id" required style="width: 100%; padding: 0.875rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem; font-family: inherit;">
                            <option value="">-- Choose a group --</option>
                            <?php foreach ($groupDetails as $gd): ?>
                                <option value="<?= htmlspecialchars($gd['group']['id'], ENT_QUOTES) ?>"><?= htmlspecialchars($gd['group']['name'], ENT_QUOTES) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="member_name">Member Name</label>
                        <input type="text" id="member_name" name="member_name" placeholder="e.g., John" required>
                    </div>
                    <button type="submit" class="btn">Add Member</button>
                </form>
            <?php else: ?>
                <p style="color: #a0aec0; text-align: center;">Create a group first to add members</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Groups Display Section -->
    <?php if (empty($groupDetails)): ?>
        <div class="section">
            <div class="empty-state">
                <div class="empty-icon">👥</div>
                <p>No groups yet. Create one to get started!</p>
            </div>
        </div>
    <?php else: ?>
        <div class="groups-grid">
            <?php foreach ($groupDetails as $gd): ?>
                <div class="group-card">
                    <div class="group-header">
                        <div>
                            <div class="group-title"><?= htmlspecialchars($gd['group']['name'], ENT_QUOTES) ?></div>
                            <?php if (!empty($gd['group']['description'])): ?>
                                <div style="font-size: 0.9rem; color: #718096; margin-top: 0.3rem;">
                                    <?= htmlspecialchars($gd['group']['description'], ENT_QUOTES) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <form method="post" action="/group/delete" style="display: inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($gd['group']['id'], ENT_QUOTES) ?>">
                            <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this group? All expenses will be removed.')">🗑️</button>
                        </form>
                    </div>

                    <div class="group-stats">
                        <div class="stat">
                            <div>👥 Members</div>
                            <div class="stat-value"><?= count($gd['group']['members']) ?></div>
                        </div>
                        <div class="stat">
                            <div>📊 Expenses</div>
                            <div class="stat-value"><?= count($gd['expenses']) ?></div>
                        </div>
                        <div class="stat">
                            <div>💵 Total</div>
                            <div class="stat-value">$<?= number_format($gd['totalExpense'], 2) ?></div>
                        </div>
                    </div>

                    <?php if (!empty($gd['group']['members'])): ?>
                        <div class="members-list">
                            <div class="members-label">Members</div>
                            <?php foreach ($gd['group']['members'] as $member): ?>
                                <span class="member-tag"><?= htmlspecialchars($member, ENT_QUOTES) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Tabs for Expenses and Transactions -->
                    <div class="tabs">
                        <button class="tab active" onclick="switchTab(event, 'expenses-<?= htmlspecialchars($gd['group']['id'], ENT_QUOTES) ?>')">
                            Expenses
                        </button>
                        <button class="tab" onclick="switchTab(event, 'transactions-<?= htmlspecialchars($gd['group']['id'], ENT_QUOTES) ?>')">
                            Settlements
                        </button>
                    </div>

                    <!-- Expenses Tab -->
                    <div id="expenses-<?= htmlspecialchars($gd['group']['id'], ENT_QUOTES) ?>" class="tab-content active">
                        <?php if (empty($gd['expenses'])): ?>
                            <div style="text-align: center; color: #a0aec0; padding: 1rem;">
                                No expenses yet
                            </div>
                        <?php else: ?>
                            <div class="expenses-list">
                                <?php foreach ($gd['expenses'] as $expense): ?>
                                    <div class="expense-item">
                                        <div class="expense-info">
                                            <div class="expense-description">
                                                <?= htmlspecialchars($expense['description'], ENT_QUOTES) ?>
                                            </div>
                                            <div class="expense-payer">
                                                Paid by <?= htmlspecialchars($expense['paid_by'], ENT_QUOTES) ?>
                                            </div>
                                        </div>
                                        <div class="expense-amount">
                                            $<?= number_format($expense['amount'], 2) ?>
                                        </div>
                                        <form method="post" action="/expense/delete" style="display: inline;">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($expense['id'], ENT_QUOTES) ?>">
                                            <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this expense?')">✕</button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Transactions Tab -->
                    <div id="transactions-<?= htmlspecialchars($gd['group']['id'], ENT_QUOTES) ?>" class="tab-content">
                        <?php if (empty($gd['transactions'])): ?>
                            <div style="text-align: center; color: #a0aec0; padding: 1rem;">
                                ✓ Everyone is settled up!
                            </div>
                        <?php else: ?>
                            <div style="margin-bottom: 1rem; font-size: 0.9rem; color: #718096; text-align: center;">
                                <strong><?= count($gd['transactions']) ?></strong> payment<?= count($gd['transactions']) !== 1 ? 's' : '' ?> needed
                            </div>
                            <?php foreach ($gd['transactions'] as $tx): ?>
                                <div class="transaction-item">
                                    <span class="transaction-from"><?= htmlspecialchars($tx['from'], ENT_QUOTES) ?></span>
                                    <span style="color: #a0aec0;">owes</span>
                                    <span class="transaction-to"><?= htmlspecialchars($tx['to'], ENT_QUOTES) ?></span>
                                    <div class="transaction-amount">
                                        $<?= number_format($tx['amount'], 2) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function switchTab(event, tabId) {
        event.preventDefault();
        
        const tabs = event.target.parentElement.querySelectorAll('.tab');
        tabs.forEach(tab => tab.classList.remove('active'));
        event.target.classList.add('active');
        
        const tabContents = event.target.parentElement.parentElement.querySelectorAll('.tab-content');
        tabContents.forEach(content => content.classList.remove('active'));
        
        document.getElementById(tabId).classList.add('active');
    }

    // Update split-with members when group is selected
    const groupSelect = document.getElementById('group_id');
    const groupsData = <?= json_encode(array_map(fn($gd) => [
        'id' => $gd['group']['id'],
        'members' => array_values(array_unique($gd['group']['members']))
    ], $groupDetails)) ?>;

    if (groupSelect) {
        groupSelect.addEventListener('change', function() {
            const splitContainer = document.getElementById('splitWithContainer');
            const groupId = this.value;

            if (!groupId) {
                splitContainer.innerHTML = '<p style="color: #a0aec0; text-align: center;">Select a group first</p>';
                return;
            }

            const group = groupsData.find(g => g.id === groupId);
            const members = group ? group.members : [];

            if (members.length === 0) {
                splitContainer.innerHTML = '<p style="color: #a0aec0; text-align: center;">No members in this group yet</p>';
                return;
            }

            splitContainer.innerHTML = members.map(member => `
                <label class="checkbox-item">
                    <input type="checkbox" name="split_with[]" value="${escapeHtml(member)}" checked>
                    <span>${escapeHtml(member)}</span>
                </label>
            `).join('');
        });

        if (groupSelect.value) {
            groupSelect.dispatchEvent(new Event('change'));
        }
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
</script>
</body>
</html>
