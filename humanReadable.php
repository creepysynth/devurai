<?php

/**
 * Converts Contacts JSON string to human-readable string
 *
 * @param string $json
 * @return string
 */
function humanReadable(string $json): string
{
    $jsonObj = json_decode($json);
    $contacts = $jsonObj->contacts;
    $output = '';

    // Assign the value of record's ID to its array key for the fast
    // and easy access to this record from array by its ID
    foreach ($jsonObj as $name => &$records) {
        // skip contact records because they do not have ID
        if ($name == 'contacts') {
            continue;
        }

        $newRecords = [];

        foreach ($records as $record) {
            $newRecords[$record->id] = $record;
        }

        if (!empty($newRecords)) {
            $records = $newRecords;
        }
    }

    // Construct human-readable string
    foreach ($contacts as $contact) {
        $userID = $contact->user;
        $userName = $jsonObj->users[$userID]->name;

        $roleID = $jsonObj->users[$userID]->role;
        $roleName = $jsonObj->roles[$roleID]->roleName;

        $permissionID = $jsonObj->users[$userID]->permissions;
        $permission = $jsonObj->permissions[$permissionID]->value;

        $output .= "$userName, $roleName, $contact->firstName $contact->lastName - $permission\n";
    }

    return $output;
}