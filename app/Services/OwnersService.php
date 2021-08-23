<?php
    namespace App\Services;

    use App\Models\Owner;
    use App\Models\Salon;
    use DB;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Rule;
    use Image;

    class OwnersService
    {
        /**
         * Validate new salon data
         *
         * @param Request $request
         *
         */
        public function validate(Request $request) {
            $validatedData = $request->validate([
                'owner_name' => 'required',
                'email' => 'required',
                'profile' => 'required',
                'name' => [
                    'required',
                    Rule::unique('salons', 'name')->whereNull('deleted_at')
                ],
                'fee' => 'required|numeric|min:100',
                'abstract' => 'required',
                'recommend' => 'required',
                'benefit' => 'required',
                'facebook' => 'required',
                'max_members' => 'required',
                'image' => 'required|max:1024|mimes:jpeg,jpg,png'
            ],
            [
                'owner_name.required' => 'オーナー名は必須です。',
                'email.required'  => 'メールアドレスは必須です。',
                'profile.required'  => 'プロフィールは必須です。',
                'name.required'  => 'サロン名は必須です。',
                "name.Rule::unique('salons', 'name')->whereNull('deleted_at')"  => '同名のサロンが登録されています。',
                'fee.required'  => '月会費は必須です。',
                'fee.numeric' => '半角数字で入力してください。',
                'fee.min:100'  => '月会費は100円以上に設定してください。',
                'abstract.required'  => '概要は必須です。',
                'abstract.required'  => 'こんな人におすすめは必須です。',
                'benefit.required'  => '特典は必須です。',
                'facebok.required'  => 'facebook URLは必須です。',
                'max_members.required'  => '最大会員数は必須です。',
                'image.required'  => '画像は必須です。',
                'image.max:1024'  => '画像は1M以内のファイルをアップロードしてください。',
                'image.mimes:jpeg,jpg,png'  => 'jpeg、jpg、png形式の画像ファイルを選んでください。'
            ]);
        }

        /**
         * Check if the owner is new
         *
         * @param String $owner_email
         *
         * @return Boolean
         */
        public function isNewOwner($owner_email) {
            $owner_id = Owner::whereNull('deleted_at')
                ->where('email', $owner_email)
                ->count();
            if($owner_id > 0){
                return false;
            } else {
                return true;
            }
        }

        /**
         * Get owner's info by email
         *
         * @param String $owner_email
         *
         * @return App/Models/Owner
         */
        public function findOwnerIdByEmail($owner_email) {
            $owner_id = Owner::whereNull('deleted_at')
                ->where('email', $owner_email)
                ->first();
            if($owner_id) {
                return $owner_id->id;
            } else {
                return NULL;
            }
        }

        /**
         * Regiser a new owner
         *
         * @param Request $request
         *
         * @return $owner_id
         */
        public function storeOwner(Request $request) {
            Owner::insert([
                'owner_name' => $request->owner_name,
                'email' => $request->email,
                'profile' => $request->profile,
                'created_at' => now()
            ]);
        }

        /**
         * Regiser a new salon
         *
         * @param Request $request
         */
        public function storeSalon(Request $request, $owner_id) {
            $file_ex = $request->file('image')->getClientOriginalExtension();
            $image_path = $request->file('image')->storeAs('public/salonImages/', $request->name.'.'.$file_ex);
            // store thumbnail
            Image::make($request->file('image'))
                ->fit(640, 640, function($constraint) {
                    $constraint->upsize();
                })
                ->save('public/salonImages/thumb-'.$request->name.'.'.$file_ex, 100);
            Salon::insert([
                'name' => $request->name,
                'fee' => $request->fee,
                'abstract' => $request->abstract,
                'recommend' => $request->recommend,
                'benefit' => $request->benefit,
                'facebook' => $request->facebook,
                'max_members' => $request->max_members,
                'image' => basename($image_path),
                'owner_id' => $owner_id,
                'created_at' => now()
            ]);
        }

        /**
         * Search matching salons with given owner email
         *
         * @param string $email
         *
         * @return App/Models/Salon
         */
        public function searchSalons($email) {
            $owner_id = $this->findOwnerIdByEmail($email);
            if($owner_id) {
                return Salon::where('owner_id', $owner_id)->get();
            } else {
                return NULL;
            }
        }
    }
