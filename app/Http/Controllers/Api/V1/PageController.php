<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\FQ;
use App\Models\NewLetter;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function faq()
        {
            $data = FQ::get()->paginate(3);

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => __('api.data_is_empty'),
                    'data' => [],
                ], Response::HTTP_OK);
            }

            $data->getCollection()->transform(function ($item) {
                return [
                    'question' => $item->question,
                    'answer' => $item->answer,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => __('api.retrieve_Faq'),
                'data' => $data,
            ], Response::HTTP_OK);
        }


        public function testimonial()
        {
            $data = Testimonial::where('is_active', 1)->paginate(3);

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => __('api.data_is_empty'),
                    'data' => [],
                ], Response::HTTP_OK);
            }

            $data->getCollection()->transform(function ($item) {
                return [
                    'name' => $item->name,
                    'comment' => $item->comment,
                    'image' => $item->image ? url("storage/{$item->image}"):null,
                    'rating' => $item->rating,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => __('api.retrieve_testimonial'),
                'data' => $data,
            ], Response::HTTP_OK);
        }



    public function newsLetter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:new_letters,email|max:255|min:5',
        ]);

        NewLetter::create($request->only('email'));

        return response()->json([
            'status' => true,
            'message' => __('api.successfully_subscribed_newsletter'),
        ], Response::HTTP_CREATED);
    }

}
