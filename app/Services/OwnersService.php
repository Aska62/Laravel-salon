<?php
    namespace App\Services;

    use App\Models\Owner;
    use App\Models\Salon;
    use Illuminate\Http\Request;
    use Image;

    class OwnersService
    {
        /**
         * Check if the owner is new
         *
         * @param String $owner_email
         *
         * @return Boolean
         */
        public function isNewOwner($owner_email) {
            $owner_count = Owner::whereNull('deleted_at')
                ->where('email', $owner_email)
                ->count();
            if($owner_count > 0){
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
         * @return Int $owner_id
         */
        public function findOwnerIdByEmail($owner_email) {
            $owner = Owner::whereNull('deleted_at')
                ->where('email', $owner_email)
                ->first();
            if($owner) {
                return $owner->id;
            } else {
                return NULL;
            }
        }

        /**
         * Regiser a new owner
         *
         * @param Array $data
         *
         */
        public function storeOwner(Array $data) {
            $owner = Owner::insert([
                'owner_name' => $data['owner_name'],
                'email' => $data['email'],
                'profile' => $data['profile'],
                'created_at' => now()
            ]);

            return $owner;
        }

        /**
         * Regiser a new salon
         *
         * @param Array $data
         * @param Int $owner_id
         */
        public function storeSalon(Request $request, $owner_id) {
            $file_ex = $request
                ->file('image')
                ->getClientOriginalExtension();
            $image_path = $request
                ->file('image')
                ->storeAs('public/salonImages/', $request->name.'.'.$file_ex);

            // store thumbnail
            Image::make($request->file('image'))
                ->fit(640, 640, function($constraint) {
                    $constraint->upsize();
                })
                ->save('public/salonImages/thumb-'.$request->name.'.'.$file_ex, 100);

            $salon = Salon::insert([
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

            return $salon;
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
        /**
         * Regiser a new salon without Image
         *
         * @param Array $data
         * @param Int $owner_id
         */
        public function storeSalonWoImage(Request $request, $owner_id) {
            $salon = Salon::insert([
                'name' => $request->name,
                'fee' => $request->fee,
                'abstract' => $request->abstract,
                'recommend' => $request->recommend,
                'benefit' => $request->benefit,
                'facebook' => $request->facebook,
                'max_members' => $request->max_members,
                'owner_id' => $owner_id,
                'created_at' => now()
            ]);

            return $salon;
        }
    }
