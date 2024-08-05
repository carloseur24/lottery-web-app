<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class usuarioController extends Controller
{
    // public function __construct() {
    // }
    public function getUserDataById()
    {
        try {
            $data = json_decode(file_get_contents('php://input'));
            $user = User::find(auth()->id());
            $results = $user->toArray();

            return json_encode($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving user data'], 500);
        }
    }
    public function getUserData()
    {
        $results = DB::select('select * from users');
        return json_encode($results);
    }
    public function updateUserData()
    {
        $raw_data = json_decode(file_get_contents('php://input'), true);
        $data = $raw_data['data'];
        // Extract data
        $nombre = $data['nombre'];
        $phone_number = $data['phone_number'];
        $cedula_number = $data['cedula_number'];
        $email = $data['email'];
        $old_password = $data['old_password'];
        $new_password = $data['new_password'];
        $password_confirmation = $data['password_confirmation'];
        $banco_id = $data['banco_id'];
        $userId = $data['id'];

        // Fetch current user data from the database
        $currentUser = DB::table('users')->where('id', $userId)->first();

        $hashedNewPassword = '';

        if ($old_password !== '') {
            // Verify old password
            if (!password_verify($old_password, $currentUser->password)) {
                return json_encode(['error' => 'Old password is incorrect']);
            }

            // Validate new password
            if ($new_password !== $password_confirmation) {
                return json_encode(['error' => 'New password and confirmation do not match']);
            }

            // Hash the new password
            $hashedNewPassword = password_hash($new_password, PASSWORD_BCRYPT);
        }
        // Prepare the update query
        $updateFields = [];
        $params = [];

        if ($nombre !== $currentUser->nombre) {
            $updateFields[] = 'nombre = ?';
            $params[] = $nombre;
        }
        if ($phone_number !== $currentUser->phone_number) {
            $updateFields[] = 'phone_number = ?';
            $params[] = $phone_number;
        }
        if ($cedula_number !== $currentUser->cedula_number) {
            $updateFields[] = 'cedula_number = ?';
            $params[] = $cedula_number;
        }
        if ($email !== $currentUser->email) {
            $updateFields[] = 'email = ?';
            $params[] = $email;
        }
        if ($banco_id !== $currentUser->banco_id) {
            $updateFields[] = 'banco_id = ?';
            $params[] = $banco_id;
        }
        if ($old_password !== '' && $new_password !== '') { // Only include the new password if it's set
            $updateFields[] = 'password = ?';
            $params[] = $hashedNewPassword;
        }

        if (empty($updateFields)) {
            return json_encode(['message' => 'No fields to update']);
        }

        $updateQuery = 'UPDATE users SET ' . implode(', ', $updateFields) . ' WHERE id = ?';
        $params[] = $userId;

        try {
            // Start a transaction
            DB::beginTransaction();

            // Execute the update query
            DB::update($updateQuery, $params);

            // Commit the transaction
            DB::commit();

            return json_encode(['message' => 'User data updated successfully']);
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            return json_encode(['error' => 'Failed to update user data: ' . $e->getMessage()]);
        }
    }
}
