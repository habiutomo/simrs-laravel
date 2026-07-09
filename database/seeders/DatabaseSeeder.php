<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Models\RoomCategory;
use App\Models\Room;
use App\Models\MedicineCategory;
use App\Models\Medicine;
use App\Models\LabTest;
use App\Models\RadiologyTest;
use App\Models\MedicalService;
use App\Models\Insurance;
use App\Models\Diagnosis;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ============ USERS ============
        $users = [
            ['name' => 'Administrator', 'email' => 'admin@rsarbunda.com', 'role' => 'admin', 'phone' => '081234567890'],
            ['name' => 'dr. Ahmad Fauzi', 'email' => 'dokter@rsarbunda.com', 'role' => 'dokter', 'phone' => '081234567891'],
            ['name' => 'Siti Rahma, S.Kep', 'email' => 'perawat@rsarbunda.com', 'role' => 'perawat', 'phone' => '081234567892'],
            ['name' => 'Dewi Sartika, S.Farm', 'email' => 'farmasi@rsarbunda.com', 'role' => 'farmasi', 'phone' => '081234567893'],
            ['name' => 'Budi Santoso, A.Md', 'email' => 'lab@rsarbunda.com', 'role' => 'lab', 'phone' => '081234567894'],
            ['name' => 'Rini Anggraini, S.Tr', 'email' => 'rad@rsarbunda.com', 'role' => 'radiologi', 'phone' => '081234567895'],
            ['name' => 'Indah Permata Sari', 'email' => 'kasir@rsarbunda.com', 'role' => 'kasir', 'phone' => '081234567896'],
        ];
        foreach ($users as $u) User::firstOrCreate(['email' => $u['email']], [...$u, 'password' => Hash::make('password'), 'is_active' => true]);

        // ============ POLYCLINICS ============
        $polyclinics = [
            ['code' => 'UMU', 'name' => 'Poli Umum', 'location' => 'Lt. 1 Gedung A'],
            ['code' => 'GIG', 'name' => 'Poli Gigi', 'location' => 'Lt. 1 Gedung A'],
            ['code' => 'ANK', 'name' => 'Poli Anak', 'location' => 'Lt. 2 Gedung A'],
            ['code' => 'OBG', 'name' => 'Poli Kebidanan & Kandungan', 'location' => 'Lt. 2 Gedung A'],
            ['code' => 'MTA', 'name' => 'Poli Mata', 'location' => 'Lt. 1 Gedung B'],
            ['code' => 'THT', 'name' => 'Poli THT', 'location' => 'Lt. 1 Gedung B'],
            ['code' => 'SRF', 'name' => 'Poli Saraf', 'location' => 'Lt. 2 Gedung B'],
            ['code' => 'JNT', 'name' => 'Poli Jantung', 'location' => 'Lt. 2 Gedung B'],
            ['code' => 'BDH', 'name' => 'Poli Bedah', 'location' => 'Lt. 1 Gedung C'],
            ['code' => 'IGD', 'name' => 'IGD', 'location' => 'Lt. 1 Gedung Utama'],
        ];
        foreach ($polyclinics as $p) Polyclinic::firstOrCreate(['code' => $p['code']], $p);

        // ============ DOCTORS ============
        $doctors = [
            ['code' => 'DR001', 'name' => 'dr. Hendra Gunawan, Sp.PD', 'specialization' => 'Penyakit Dalam', 'phone' => '0811111111', 'sip' => 'SIP-001/RSAB/2024', 'consultation_fee' => 150000],
            ['code' => 'DR002', 'name' => 'dr. Maya Sari, Sp.A', 'specialization' => 'Anak', 'phone' => '0811111112', 'sip' => 'SIP-002/RSAB/2024', 'consultation_fee' => 150000],
            ['code' => 'DR003', 'name' => 'dr. Budi Prasetyo, Sp.OG', 'specialization' => 'Kebidanan & Kandungan', 'phone' => '0811111113', 'sip' => 'SIP-003/RSAB/2024', 'consultation_fee' => 200000],
            ['code' => 'DR004', 'name' => 'dr. Agus Wijaya, Sp.M', 'specialization' => 'Mata', 'phone' => '0811111114', 'sip' => 'SIP-004/RSAB/2024', 'consultation_fee' => 125000],
            ['code' => 'DR005', 'name' => 'dr. Rina Febrianti, Sp.THT', 'specialization' => 'THT', 'phone' => '0811111115', 'sip' => 'SIP-005/RSAB/2024', 'consultation_fee' => 125000],
            ['code' => 'DR006', 'name' => 'dr. Andi Pratama, Sp.S', 'specialization' => 'Saraf', 'phone' => '0811111116', 'sip' => 'SIP-006/RSAB/2024', 'consultation_fee' => 200000],
            ['code' => 'DR007', 'name' => 'dr. Dian Permata, Sp.JP', 'specialization' => 'Jantung', 'phone' => '0811111117', 'sip' => 'SIP-007/RSAB/2024', 'consultation_fee' => 250000],
            ['code' => 'DR008', 'name' => 'dr. Fajar Ramadhan, Sp.B', 'specialization' => 'Bedah Umum', 'phone' => '0811111118', 'sip' => 'SIP-008/RSAB/2024', 'consultation_fee' => 250000],
            ['code' => 'DR009', 'name' => 'dr. Lestari Dewi, Sp.PD', 'specialization' => 'Penyakit Dalam', 'phone' => '0811111119', 'sip' => 'SIP-009/RSAB/2024', 'consultation_fee' => 150000],
        ];
        foreach ($doctors as $d) Doctor::firstOrCreate(['code' => $d['code']], $d);

        // ============ ROOM CATEGORIES ============
        $categories = [
            ['name' => 'VVIP', 'rate_per_day' => 750000],
            ['name' => 'VIP', 'rate_per_day' => 500000],
            ['name' => 'Kelas I', 'rate_per_day' => 300000],
            ['name' => 'Kelas II', 'rate_per_day' => 200000],
            ['name' => 'Kelas III', 'rate_per_day' => 100000],
            ['name' => 'ICU', 'rate_per_day' => 1500000],
            ['name' => 'NICU', 'rate_per_day' => 1000000],
        ];
        foreach ($categories as $c) RoomCategory::firstOrCreate(['name' => $c['name']], $c);

        // ============ ROOMS ============
        $catIds = RoomCategory::pluck('id', 'name');
        $roomData = [
            ['VVIP', ['VVIP-01', 'VVIP-02']],
            ['VIP', ['VIP-01', 'VIP-02', 'VIP-03', 'VIP-04']],
            ['Kelas I', ['I-A', 'I-B', 'I-C', 'I-D']],
            ['Kelas II', ['II-A', 'II-B', 'II-C', 'II-D', 'II-E', 'II-F']],
            ['Kelas III', ['III-A', 'III-B', 'III-C', 'III-D', 'III-E', 'III-F', 'III-G', 'III-H']],
            ['ICU', ['ICU-01', 'ICU-02']],
            ['NICU', ['NICU-01', 'NICU-02']],
        ];
        foreach ($roomData as [$catName, $rooms]) {
            foreach ($rooms as $r) {
                $catId = $catIds[$catName];
                Room::firstOrCreate(
                    ['room_category_id' => $catId, 'room_number' => $r],
                    ['room_category_id' => $catId, 'room_number' => $r, 'name' => "Ruang $catName - $r", 'status' => 'available']
                );
            }
        }

        // ============ MEDICINE CATEGORIES ============
        $medCats = ['Antibiotik', 'Analgesik', 'Antipiretik', 'Vitamin & Suplemen', 'Obat Jantung', 'Obat Lambung', 'Obat Alergi', 'Cairan Infus', 'Anti Hipertensi', 'Antidiabetes'];
        foreach ($medCats as $mc) MedicineCategory::firstOrCreate(['name' => $mc]);

        // ============ MEDICINES ============
        $medCatIds = MedicineCategory::pluck('id', 'name');
        $medicines = [
            ['Amoxicillin 500mg', 'Antibiotik', 'tablet', 5000, 500],
            ['Paracetamol 500mg', 'Analgesik', 'tablet', 2000, 1000],
            ['Ibuprofen 400mg', 'Analgesik', 'tablet', 3000, 500],
            ['Ciprofloxacin 500mg', 'Antibiotik', 'tablet', 8000, 300],
            ['Omeprazole 20mg', 'Obat Lambung', 'kapsul', 4000, 400],
            ['Captopril 25mg', 'Anti Hipertensi', 'tablet', 1500, 600],
            ['Metformin 500mg', 'Antidiabetes', 'tablet', 3000, 400],
            ['Vitamin C 50mg', 'Vitamin & Suplemen', 'tablet', 1000, 1000],
            ['CTM 4mg', 'Obat Alergi', 'tablet', 500, 800],
            ['Dopamin 200mg', 'Obat Jantung', 'ampul', 25000, 100],
            ['Lansoprazole 30mg', 'Obat Lambung', 'kapsul', 5000, 300],
            ['Ambroxol 30mg', 'Analgesik', 'tablet', 2500, 500],
            ['Ringer Laktat', 'Cairan Infus', 'botol', 35000, 100],
            ['NaCl 0.9%', 'Cairan Infus', 'botol', 30000, 100],
            ['Dextrose 5%', 'Cairan Infus', 'botol', 35000, 80],
            ['Amoxicillin Sirup', 'Antibiotik', 'botol', 25000, 50],
        ];
        foreach ($medicines as $i => [$name, $cat, $unit, $price, $stock]) {
            $code = 'OBT-' . str_pad($i+1, 4, '0', STR_PAD_LEFT);
            Medicine::firstOrCreate(
                ['code' => $code],
                ['medicine_category_id' => $medCatIds[$cat], 'code' => $code, 'name' => $name, 'unit' => $unit, 'price' => $price, 'stock' => $stock, 'min_stock' => 50]
            );
        }

        // ============ LAB TESTS ============
        $labTests = [
            ['LAB-001', 'Darah Rutin', 'Hematologi', 'Darah', 50000],
            ['LAB-002', 'Gula Darah Sewaktu', 'Kimia Klinik', 'Darah', 30000],
            ['LAB-003', 'Gula Darah Puasa', 'Kimia Klinik', 'Darah', 35000],
            ['LAB-004', 'Kolesterol Total', 'Kimia Klinik', 'Darah', 40000],
            ['LAB-005', 'Asam Urat', 'Kimia Klinik', 'Darah', 35000],
            ['LAB-006', 'SGOT/SGPT', 'Kimia Klinik', 'Darah', 45000],
            ['LAB-007', 'Ureum & Kreatinin', 'Kimia Klinik', 'Darah', 50000],
            ['LAB-008', 'Urine Lengkap', 'Urinalisis', 'Urine', 35000],
            ['LAB-009', 'Widal Test', 'Imunologi', 'Darah', 60000],
            ['LAB-010', 'HBsAg', 'Imunologi', 'Darah', 70000],
            ['LAB-011', 'Tes Kehamilan', 'Imunologi', 'Urine', 25000],
            ['LAB-012', 'Analisa Gas Darah', 'Kimia Klinik', 'Darah', 80000],
        ];
        foreach ($labTests as [$code, $name, $cat, $sample, $price]) LabTest::firstOrCreate(['code' => $code], ['code' => $code, 'name' => $name, 'category' => $cat, 'sample_type' => $sample, 'price' => $price]);

        // ============ RADIOLOGY TESTS ============
        $radTests = [
            ['RAD-001', 'Foto Thorax', 'Rontgen', 100000, 'Puasa tidak diperlukan'],
            ['RAD-002', 'Foto Abdomen', 'Rontgen', 100000, 'Puasa 4 jam'],
            ['RAD-003', 'Foto Ekstremitas', 'Rontgen', 85000, 'Tidak ada persiapan khusus'],
            ['RAD-004', 'USG Abdomen', 'USG', 200000, 'Puasa 8 jam'],
            ['RAD-005', 'USG Kebidanan', 'USG', 200000, 'Minum air putih 2 jam sebelumnya'],
            ['RAD-006', 'CT Scan Kepala', 'CT Scan', 500000, 'Puasa 4 jam'],
            ['RAD-007', 'EKG', 'Lainnya', 75000, 'Tidak ada persiapan khusus'],
        ];
        foreach ($radTests as [$code, $name, $cat, $price, $prep]) RadiologyTest::firstOrCreate(['code' => $code], ['code' => $code, 'name' => $name, 'category' => $cat, 'price' => $price, 'preparation' => $prep]);

        // ============ MEDICAL SERVICES ============
        $services = [
            ['SVC-001', 'Jasa Konsultasi Dokter Umum', 'Konsultasi', 75000],
            ['SVC-002', 'Jasa Konsultasi Dokter Spesialis', 'Konsultasi', 150000],
            ['SVC-003', 'Tindakan Jahit Luka', 'Tindakan', 100000],
            ['SVC-004', 'Tindakan Ganti Balut', 'Tindakan', 50000],
            ['SVC-005', 'Tindakan Infus', 'Tindakan', 35000],
            ['SVC-006', 'Tindakan Suntik', 'Tindakan', 20000],
            ['SVC-007', 'Tindakan EKG', 'Tindakan', 75000],
            ['SVC-008', 'Tindakan Nebulizer', 'Tindakan', 40000],
            ['SVC-009', 'Administrasi Pendaftaran', 'Administrasi', 15000],
            ['SVC-010', 'Biaya Rawat Inap (Administrasi)', 'Administrasi', 25000],
            ['SVC-011', 'Ambulans Dalam Kota', 'Tindakan', 200000],
            ['SVC-012', 'Visite Dokter Spesialis', 'Konsultasi', 100000],
        ];
        foreach ($services as [$code, $name, $cat, $price]) MedicalService::firstOrCreate(['code' => $code], ['code' => $code, 'name' => $name, 'category' => $cat, 'price' => $price]);

        // ============ INSURANCE ============
        $insurances = [
            ['name' => 'BPJS Kesehatan', 'type' => 'JKN', 'coverage_percentage' => 100],
            ['name' => 'PT. Jasa Raharja', 'type' => 'Asuransi', 'coverage_percentage' => 100],
            ['name' => 'Mandiri Inhealth', 'type' => 'Asuransi', 'coverage_percentage' => 90],
            ['name' => 'Prudential', 'type' => 'Asuransi', 'coverage_percentage' => 80],
            ['name' => 'AIA', 'type' => 'Asuransi', 'coverage_percentage' => 80],
            ['name' => 'Umum / Bayar Sendiri', 'type' => 'Lainnya', 'coverage_percentage' => 0],
        ];
        foreach ($insurances as $ins) Insurance::firstOrCreate(['name' => $ins['name']], $ins);

        // ============ DIAGNOSES (ICD-10) ============
        $diagnoses = [
            ['A00.0', 'Kolera', 'ICD-10'],
            ['A09', 'Diare & Gastroenteritis', 'ICD-10'],
            ['A15.0', 'Tuberkulosis Paru', 'ICD-10'],
            ['E10', 'Diabetes Melitus Tipe 1', 'ICD-10'],
            ['E11', 'Diabetes Melitus Tipe 2', 'ICD-10'],
            ['I10', 'Hipertensi Esensial', 'ICD-10'],
            ['I11', 'Penyakit Jantung Hipertensi', 'ICD-10'],
            ['I48', 'Fibrilasi Atrium', 'ICD-10'],
            ['J00', 'Nasofaringitis Akut (Common Cold)', 'ICD-10'],
            ['J02.9', 'Faringitis Akut', 'ICD-10'],
            ['J03.9', 'Tonsilitis Akut', 'ICD-10'],
            ['J06.9', 'Infeksi Saluran Pernapasan Atas Akut (ISPA)', 'ICD-10'],
            ['J15', 'Pneumonia', 'ICD-10'],
            ['J45', 'Asma', 'ICD-10'],
            ['K29.7', 'Gastritis Akut', 'ICD-10'],
            ['K30', 'Dispepsia', 'ICD-10'],
            ['L03', 'Selulitis', 'ICD-10'],
            ['M54.5', 'Low Back Pain', 'ICD-10'],
            ['N20.0', 'Batu Ginjal', 'ICD-10'],
            ['N39.0', 'Infeksi Saluran Kemih', 'ICD-10'],
            ['O80', 'Persalinan Normal', 'ICD-10'],
            ['R10.1', 'Nyeri Abdomen', 'ICD-10'],
            ['R51', 'Sakit Kepala', 'ICD-10'],
            ['S61.0', 'Luka Terbuka Jari Tangan', 'ICD-10'],
        ];
        foreach ($diagnoses as [$code, $name, $cat]) Diagnosis::firstOrCreate(['code' => $code], ['code' => $code, 'name' => $name, 'category' => $cat]);

        // ============ SUPPLIERS ============
        $suppliers = [
            ['name' => 'PT. Kimia Farma Tbk', 'phone' => '021-1234567', 'address' => 'Jakarta', 'pic_name' => 'Bambang'],
            ['name' => 'PT. Kalbe Farma Tbk', 'phone' => '021-7654321', 'address' => 'Jakarta', 'pic_name' => 'Susilo'],
            ['name' => 'PT. Anugerah Pharmindo', 'phone' => '0711-123456', 'address' => 'Palembang', 'pic_name' => 'Hendra'],
            ['name' => 'UD. Sinar Medika', 'phone' => '0733-123456', 'address' => 'Lubuklinggau', 'pic_name' => 'Rudi'],
        ];
        foreach ($suppliers as $s) Supplier::firstOrCreate(['name' => $s['name']], $s);
    }
}
