<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\API\AuthRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\clinic; // Import the clinic model

class ClinicController extends Controller
{
    use \Laravel\Sanctum\HasApiTokens;

    public function index()
    {
        $clinic = clinic::all();
        return $clinic;
        // return view ('register');
        
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'specialty' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|string|email|unique:clinic,email',
            'pass' => 'required|string|min:8',
            'category' => 'required|string',
        ]);

        $clinic = clinic::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'specialty'    => $request->specialty,
            'phone_number' => $request->phone_number,
            'email'        => $request->email,
            'pass'         => bcrypt($request->pass),
            'category'     => $request->category,
        ]);

       $token = $clinic->createToken("clinicToken")->plainTextToken;

        return response()->json([
            "clinic" => $clinic,
            "clinic_token" => $token
        ], Response::HTTP_CREATED);

    }

    public function show($id)
    {
        $clinic = clinic::find($id);
        return $clinic ? $clinic : response()->json(['message' => 'Clinic not found'], Response::HTTP_NOT_FOUND);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'specialty' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|string|email|unique:clinic,email,' . $id,
            'pass' => 'required|string|min:8',
            'category' => 'required|string',
        ]);

        $clinic = clinic::find($id);
        if ($clinic) {
            $clinic->update($request->all());
            return $clinic;
        } else {
            return response()->json(['message' => 'Clinic not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        $clinic = clinic::find($id);
        if ($clinic) {
            $clinic->delete();
            return response()->json(['message' => 'Clinic deleted successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Clinic not found'], Response::HTTP_NOT_FOUND);
        }
    }

    private const LOGIN_SUCCESS = 'Logged in successfully.';
    private const LOGIN_FAILED = 'The credentials do not match.';
    private const LOGOUT_SUCCESS = 'Logged out successfully.';

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'pass' => 'required|string|min:8',
        ]);

        $clinic = $this->getUserByEmail($request->input('email'));

        if (!$clinic || !Hash::check($request->input('pass'), $clinic->pass)) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        return response()->json(['message' => 'Login successful']);
        
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()->tokens()->delete()) {
            return $this->wrapResponse(Response::HTTP_OK, self::LOGOUT_SUCCESS);
        }
    }

    private function getUserByEmail(string $email): ?Clinic
    {
        return clinic::where('email', $email)->first();
    }

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

    private const SUCCESS_MESSAGE = 'Account has been successfully registered, please check your email to verify your account.';
    private const FAILED_MESSAGE = 'Your account failed to register.';

    public function __invoke(AuthRequest $request): JsonResponse
    {
        if ($user = clinic::create($request->validatedData())) {
            event(new Registered($user));

            return response()->json(['code' => Response::HTTP_CREATED, 'message' => self::SUCCESS_MESSAGE], Response::HTTP_CREATED);
        }

        return response()->json(['code' => 500, 'message' => self::FAILED_MESSAGE], 500);
    }
}