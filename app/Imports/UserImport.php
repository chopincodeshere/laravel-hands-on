<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $headers = $rows->first();
        $dataRows = $rows->skip(1);
        foreach ($dataRows as $row) {
            $user_data = [
                'name' => $row[0],
                'profile_image' => (isset($row[1]) ? $row[1] : null),
                'phone_number' => $row[2],
                'email' => $row[3],
                'password' => bcrypt($row[4]),
                'latitude' => $row[5],
                'longitude' => $row[6],
                'type' => $row[7],
                'otp' => $row[8],
                'is_phone_verified' => $row[9],
                'is_email_verified' => $row[10],
                'firebase_tokens' => explode(',', $row[11]),
            ];
            foreach ($headers as $key => $header) {
                $user_data[$header] = $row[$key]; // Map data based on header names
            }
            User::create($user_data);
        }
    }
}
