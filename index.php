<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.4/dist/tailwind.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Budgeting & Expense Tracker
    </title>
</head>

<body>
    <div class="container mx-auto mt-16 mb-16">
        <table class="min-w-full bg-white border border-gray-300 text-center">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Date</th>
                    <th class="py-2 px-4 border-b">Check</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loading the transactions file
                $file = fopen('./transaction_files/sample_1.csv', 'r');
                // If the file is loaded successfully
                if ($file) {
                    // To track if it's the first row
                    $is_first_row = true;
                    $total_income = $total_expense = 0;
                    while (($row = fgetcsv($file)) !== false) {
                        // Skip the first row
                        if ($is_first_row) {
                            $is_first_row = false;
                            continue;
                        }
                        echo '<tr>';
                        foreach ($row as $cell) {
                            if (strpos($cell,'$')!==false){
                                $amount = (float) filter_var($cell, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                                if ($amount>0){
                                    $total_income+=$amount;
                                    $color_class = 'text-green-500';
                                }
                                else {
                                    $total_expense+=$amount;
                                    $color_class = 'text-red-500';
                                }
                                echo "<td class='py-2 px-4 border-b $color_class'>$cell</td>";
                            }
                            else {
                                echo "<td class='py-2 px-4 border-b $'>$cell</td>";
                            }
                        }
                        echo '</tr>';
                    }
                }
                fclose($file);
                // Display footer row with totals
                echo '<tfoot>';
                echo '<tr>';
                echo "<td colspan='3' class='py-2 px-4 border-b font-bold text-right'>Total Income</td>";
                echo "<td class='py-2 px-4 border-b font-bold'>$".number_format($total_income,2)."</td>";
                echo '</tr>';
                echo '<tr>';
                echo "<td colspan='3' class='py-2 px-4 border-b font-bold text-right'>Total Expense</td>";
                echo "<td class='py-2 px-4 border-b font-bold'>$".number_format($total_expense,2)."</td>";
                echo '</tr>';
                echo '<tr>';
                echo "<td colspan='3' class='py-2 px-4 border-b font-bold text-right'>Net Total</td>";
                echo "<td class='py-2 px-4 border-b font-bold'>$" . number_format($total_income-abs($total_expense),2) ."</td>";
                echo '</tr>';
                echo '</tfoot>';
                ?>
            </tbody>
        </table>
    </div>
    
</body>

</html>
