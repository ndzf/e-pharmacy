<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionDetailModel;
use App\Models\TransactionModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends BaseController
{
    public function omzet()
    {
        $transactionDetailModel = new TransactionDetailModel();
        $transactionModel =  new TransactionModel();
        $inputs = [
            "start"         => esc($this->request->getVar("start")),
            "end"           => esc($this->request->getVar("end")),
            "date"          => $this->request->getVar("daterange"),
        ];

        $transactions = $transactionModel->between($inputs["start"], $inputs["end"]);
        $products = [];
        foreach ($transactions as $transaction) {
            $transactionDetails = $transactionDetailModel->getProductsByTransaction($transaction->id);
            $product = ["payment_status" => $transaction->payment_status, "date" => $transaction->date];
            foreach ($transactionDetails as $transactionDetail) {
                $product += $transactionDetailModel->getProduct($transactionDetail->id);
                array_push($products, $product);
            }
        }

        $data = [
            "title"             => "Laporan Omzet",
            "inputs"            => $inputs,
            "products"          => $products
        ];

        return view("reports/omzet", $data);
    }

    public function attemptExportOmzet()
    {
        // Disable memory limit
        ini_set("memory_limit", "-1");
        set_time_limit(0);

        $transactionDetailModel = new TransactionDetailModel();
        $transactionModel =  new TransactionModel();
        $inputs = esc($this->request->getPost());

        // Get transactions
        $transactions = $transactionModel->between($inputs["start"], $inputs["end"]);
        $products = [];
        foreach ($transactions as $transaction) {
            $transactionDetails = $transactionDetailModel->getProductsByTransaction($transaction->id);
            $product = ["payment_status" => $transaction->payment_status, "date" => $transaction->date];
            foreach ($transactionDetails as $transactionDetail) {
                $product += $transactionDetailModel->getProduct($transactionDetail->id);
                array_push($products, $product);
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "Tanggal");
        $sheet->setCellValue("B1", "Product");
        $sheet->setCellValue("C1", "Harga Beli");
        $sheet->setCellValue("D1", "Harga Jual");
        $sheet->setCellValue("E1", "Qty");
        $sheet->setCellValue("F1", "Payment Status");
        $sheet->setCellValue("G1", "Omzet");

        $totalOmzet = 0;
        $column = 2;

        foreach ($products as $product) {
            $omzet = ($product["product_price"] - $product["original_price"]) * $product["qty"];
            $sheet->setCellValue("A{$column}", $product["date"]);
            $sheet->setCellValue("B{$column}", $product["product"] ?? $product["product_name"]);
            $sheet->setCellValue("C{$column}", $product["original_price"]);
            $sheet->setCellValue("D{$column}", $product["product_price"]);
            $sheet->setCellValue("E{$column}", $product["qty"]);
            $sheet->setCellValue("F{$column}", $product["payment_status"]);
            $sheet->setCellValue("G{$column}", $omzet);
            $totalOmzet += $omzet;
            $column++;
        }

        $last = $column + 1;
        $sheet->setCellValue("A{$last}", "Total Omzet");
        $sheet->setCellValue("B{$last}", $totalOmzet);
        $writer = new Xlsx($spreadsheet);

        $fileName = "Laporan Omzet $inputs[start] - $inputs[start]";

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');    // download file 
        die;
    }
}
