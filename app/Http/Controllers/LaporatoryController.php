<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\API\AuthRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\laporatory; // Import the laporatory model

class LaporatoryController extends Controller
{
    use \Laravel\Sanctum\HasApiTokens;
//--------------------------------------------------------------------------------------------------------
//تستخدم لاسترجاع كل المختبرات الموجودة في قاعدة البيانات.
public function index()
    {
        $laporatory = laporatory::all();
        return $laporatory;
    }
//--------------------------------------------------------------------------------------------------------
//تُستخدم لتسجيل مختبر جديد.
//يتم التحقق من صحة البيانات المدخلة من قبل المستخدم.
//إذا كانت البيانات صحيحة، يتم إنشاء مختبر جديد وإرجاع رمز مميز (Token) له.
public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'specialty' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|string|email|unique:laporatory,email',
            'pass' => 'required|string|min:8',
            'category' => 'required|string',
        ]);

        $laporatory = laporatory::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'specialty' => $request->specialty,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'pass' => bcrypt($request->pass),
            'category' => $request->category,
        ]);

        $token = $laporatory->createToken("laporatoryToken")->plainTextToken;

        return response()->json([
            "laporatory" => $laporatory,
            "laporatory_token" => $token
        ], Response::HTTP_CREATED);
    }
//--------------------------------------------------------------------------------------------------------
//تُستخدم لعرض معلومات مختبر محدد بواسطة معرفه.
    public function show($id)
    {
        $laporatory = laporatory::find($id);
        return $laporatory ? $laporatory : response()->json(['message' => 'laporatory not found'], Response::HTTP_NOT_FOUND);
    }
//--------------------------------------------------------------------------------------------------------
//تُستخدم لتحديث معلومات مختبر محدد.
//يتم التحقق من صحة البيانات المدخلة قبل التحديث.
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'specialty' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|string|email|unique:laporatory,email,' . $id,
            'pass' => 'required|string|min:8',
            'category' => 'required|string',
        ]);

        $laporatory = laporatory::find($id);
        if ($laporatory) {
            $laporatory->update($request->all());
            return $laporatory;
        } else {
            return response()->json(['message' => 'laporatory not found'], Response::HTTP_NOT_FOUND);
        }
    }
//--------------------------------------------------------------------------------------------------------
//تُستخدم لحذف مختبر محدد من قاعدة البيانات.

    public function destroy($id)
    {
        $laporatory = laporatory::find($id);
        if ($laporatory) {
            $laporatory->delete();
            return response()->json(['message' => 'laporatory deleted successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'laporatory not found'], Response::HTTP_NOT_FOUND);
        }
    }
//--------------------------------------------------------------------------------------------------------

    private const LOGIN_SUCCESS = 'Logged in successfully.';
    private const LOGIN_FAILED = 'The credentials do not match.';
    private const LOGOUT_SUCCESS = 'Logged out successfully.';
//--------------------------------------------------------------------------------------------------------
//تُستخدم للسماح للمستخدمين بتسجيل الدخول إلى حساباتهم.
//يتم التحقق من صحة البيانات المدخلة
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'pass' => 'required|string|min:8',
        ]);

        $laporatory = $this->getUserByEmail($request->input('email'));

        if (!$laporatory || !Hash::check($request->input('pass'), $laporatory->pass)) {
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
//تُستخدم لتسجيل الخروج للمستخدمين المسجلين.
    private function getUserByEmail(string $email): ?laporatory
    {
        return laporatory::where('email', $email)->first();
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
//--------------------------------------------------------------------------------------------------------
//تُستخدم لمعالجة طلبات التسجيل.
    public function __invoke(AuthRequest $request): JsonResponse
    {
        if ($user = laporatory::create($request->validatedData())) {
            event(new Registered($user));

            return response()->json(['code' => Response::HTTP_CREATED, 'message' => self::SUCCESS_MESSAGE], Response::HTTP_CREATED);
        }

        return response()->json(['code' => 500, 'message' => self::FAILED_MESSAGE], 500);
    }
}