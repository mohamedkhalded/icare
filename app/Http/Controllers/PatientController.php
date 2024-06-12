<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\API\AuthRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Patient; // Import the Patient model

class PatientController extends Controller
{
    use \Laravel\Sanctum\HasApiTokens;
//--------------------------------------------------------------------------------------------------------

    public function index()
    {
        $Patient = Patient::all();
        return $Patient;
    }
//--------------------------------------------------------------------------------------------------------
    public function register(Request $request)
    {
        $request->validate([
            'name1' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string|email|unique:Patient,email,',
            'pass' => 'required|string|min:8',
        ]);

        $Patient = Patient::create([
            'name1' => $request->name1,
            'phone' => $request->phone,
            'email' => $request->email,
            'pass' => bcrypt($request->pass),
        ]);

        $token = $Patient->createToken("patientToken")->plainTextToken;

        return response()->json([
            "Patient" => $Patient,
            "patient_token" => $token
        ], Response::HTTP_CREATED);
    }
//--------------------------------------------------------------------------------------------------------

    public function show($id)
    {
        $Patient = Patient::find($id);
        return $Patient ? $Patient : response()->json(['message' => 'patient not found'], Response::HTTP_NOT_FOUND);
    }
//--------------------------------------------------------------------------------------------------------

    public function update(Request $request, $id)
    {
        $request->validate([
            'name1' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string|email|unique:Patient,email,' . $id,
            'pass' => 'required|string|min:8',
        ]);

        $Patient = Patient::find($id);
        if ($Patient) {
            $Patient->update($request->all());
            return $Patient;
        } else {
            return response()->json(['message' => 'patient not found'], Response::HTTP_NOT_FOUND);
        }
    }
//--------------------------------------------------------------------------------------------------------

    public function destroy($id)
    {
        $Patient = Patient::find($id);
        if ($Patient) {
            $Patient->delete();
            return response()->json(['message' => 'patient deleted successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'patient not found'], Response::HTTP_NOT_FOUND);
        }
    }
//--------------------------------------------------------------------------------------------------------

    private const LOGIN_SUCCESS = 'Logged in successfully.';
    private const LOGIN_FAILED = 'The credentials do not match.';
    private const LOGOUT_SUCCESS = 'Logged out successfully.';
//--------------------------------------------------------------------------------------------------------

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'pass' => 'required|string|min:8',
        ]);

        $Patient = $this->getUserByEmail($request->input('email'));

        if (!$Patient || !Hash::check($request->input('pass'), $Patient->pass)) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        return response()->json(['message' => 'Login successful']);
        
    } 
//--------------------------------------------------------------------------------------------------------

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()->tokens()->delete()) {
            return $this->wrapResponse(Response::HTTP_OK, self::LOGOUT_SUCCESS);
        }
    }
//--------------------------------------------------------------------------------------------------------

    private function getUserByEmail(string $email): ?patient
    {
        return Patient::where('email', $email)->first();
    }
//--------------------------------------------------------------------------------------------------------

    private function wrapResponse(int $code, string $message, ?array $resource = []): JsonResponse
    {
        $result = [
            'code' => $code,
            'message' => $message
        ];

        if (count($resource)) {
            $result = array_merge(
                $result,
                [
                    'data' => $resource['data'],
                    'token' => $resource['token']
                ]
            );
        }

        return response()->json($result);
    }
//--------------------------------------------------------------------------------------------------------

    private const SUCCESS_MESSAGE = 'Account has been successfully registered, please check your email to verify your account.';
    private const FAILED_MESSAGE = 'Your account failed to register.';

    public function __invoke(AuthRequest $request): JsonResponse
    {
        if ($user = Patient::create($request->validatedData())) {
            event(new Registered($user));

            return response()->json(['code' => Response::HTTP_CREATED, 'message' => self::SUCCESS_MESSAGE], Response::HTTP_CREATED);
        }

        return response()->json(['code' => 500, 'message' => self::FAILED_MESSAGE], 500);
    }
}