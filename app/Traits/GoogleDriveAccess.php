<?php

namespace App\Traits;

use Google\Client;
use Google\Service\Drive;
use DB;

trait GoogleDriveAccess
{
    public function getAllFolders()
    {
        // Initialize Google Client
        $client = new Client();
        $client->setClientId(config('google-drive.client_id'));
        $client->setClientSecret(config('google-drive.client_secret'));
        $client->refreshToken(config('google-drive.refresh_token'));

        // Create Google Drive service
        $service = new Drive($client);

        // Retrieve all folders recursively
        $folders = $this->getFoldersRecursively($service, config('google-drive.folder_id'));

        // Return folder names as JSON response
        return response()->json($folders);
    }

    private function getFoldersRecursively($service, $parentId)
    {
        $folders = [];

        // Define query parameters to filter folders
        $queryParams = [
            'q' => "'$parentId' in parents and mimeType='application/vnd.google-apps.folder' and trashed=false",
            'fields' => 'files(id, name)',
        ];

        // Retrieve folders from Google Drive
        $results = $service->files->listFiles($queryParams);

        // Extract folder names from results
        foreach ($results->getFiles() as $folder) {
            $folders[] = [
                'id' => $folder->getId(),
                'name' => $folder->getName(),
                'url' => 'https://drive.google.com/drive/folders/' . $folder->getId(),
            ];

            // Recursively fetch subfolders
            $subFolders = $this->getFoldersRecursively($service, $folder->getId());
            $folders = array_merge($folders, $subFolders);
        }

        return $folders;
    }

    public function selectFolderOptions(){
        $folders = $this->getAllFolders()->original;
        // Prepare options for the dropdown
        $folderOptions = [];
        foreach ($folders as $folder) {
            $folderOptions[] = $folder['url'] . '|' . $folder['name'];
        }

        return implode(';', $folderOptions);
    }

    public function selectFolders(){
        return $this->getAllFolders()->original;
    }

    public function selectEmails(){
        return implode(";",array_map(function($item) {
            return $item->email;
        }, DB::table('cms_users')->get('email')->toArray()));
    }
}
