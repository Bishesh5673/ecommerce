<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6 max-w-4xl">
        <div id="invoice" class="bg-white shadow-lg rounded-lg p-8">
            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Invoice</h1>
                    <p class="text-gray-600">Date: {{ now()->format('F d, Y') }}</p>
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-semibold text-gray-800">Company Name</h2>
                    <p class="text-gray-600">123 Business St, City, Country</p>
                    <p class="text-gray-600">contact@company.com</p>
                </div>
            </div>

            <!-- Order Details -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p><strong>User Name:</strong> {{ $order->user->name }}</p>
                        <p><strong>Seller:</strong> {{ $order->seller->name }}</p>
                        <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                    </div>
                    <div>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Descriptions -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Items</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 border-b">Product Name</th>
                                <th class="p-3 border-b">Quantity</th>
                                <th class="p-3 border-b">Amount</th>
                                <th class="p-3 border-b">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->order_descriptions as $description)
                                <tr class="border-b">
                                    <td class="p-3">{{ $description->product->name }}</td>
                                    <td class="p-3">{{ $description->quantity }}</td>
                                    <td class="p-3">${{ number_format($description->amount, 2) }}</td>
                                    <td class="p-3">
                                        ${{ number_format($description->quantity * $description->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total -->
            <div class="text-right">
                <p class="text-lg font-semibold">Grand Total: ${{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>

        <!-- Download Button -->
        <div class="mt-6 text-center no-print">
            <button onclick="downloadPDF()"
                class="bg-blue-600 cursor-pointer text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                Download Invoice as PDF
            </button>
        </div>
    </div>

    <script>
        function downloadPDF() {
            const element = document.getElementById('invoice');
            const options = {
                margin: 0.5,
                filename: 'invoice.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };
            html2pdf().from(element).set(options).save();
        }
    </script>
</body>

</html>
