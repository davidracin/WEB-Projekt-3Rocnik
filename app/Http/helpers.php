<?php
if (!function_exists('delete_modal')) {
    function delete_modal($idModal, $idRow, $heading, $message, $route, $type = "danger", $buttonText = "Smazat")
    {
        $result = "";
        $result .= "<div class=\"modal fade\" id=\"" . $idModal . "\">\n";
        $result .= "<div class=\"modal-dialog\">\n";
        $result .= " <div class=\"modal-content\">\n";
        $result .= "<div class=\"modal-header\">\n";
        $result .= "<h4 class=\"modal-title\">" . $heading . "</h4>\n";
        $result .= "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>\n";
        $result .= "</div>\n";
        $result .= "<div class=\"modal-body\">\n";
        $result .= $message . "\n";
        $result .= "</div>\n";
        $result .= "<div class=\"modal-footer\">\n";
        $result .= "<form method=\"POST\" action=\"" . $route . "\">\n";
        $result .= "<input type=\"hidden\" name=\"_method\" value=\"DELETE\">";
        $result .= "<input type=\"hidden\" name=\"_token\" value=\"" . csrf_token() . "\">";
        $result .= "<input type=\"hidden\" name=\"id\" value=\"" . $idRow . "\">";
        $result .= "<button type=\"submit\" class=\"btn btn-" . $type . "\" data-bs-dismiss=\"modal\">" . $buttonText . "</button>\n";
        $result .= "</form>\n";
        $result .= "</div>\n</div>\n</div>\n</div>\n";

        return $result;
    }
}


if (!function_exists('edit_modal')) {
    function edit_modal($idModal, $heading, $route, $dbData = null, $fields = [], $excludeFields = ['id', 'created_at', 'updated_at', 'deleted_at'], $type = "primary", $buttonText = "Upravit")
    {
        $result = "";
        $result .= "<div class=\"modal fade\" id=\"" . $idModal . "\">\n";
        $result .= "<div class=\"modal-dialog\">\n";
        $result .= " <div class=\"modal-content\">\n";
        $result .= "<div class=\"modal-header\">\n";
        $result .= "<h4 class=\"modal-title\">" . $heading . "</h4>\n";
        $result .= "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>\n";
        $result .= "</div>\n";
        $result .= "<div class=\"modal-body\">\n";
        $result .= "<form method=\"POST\" action=\"" . $route . "\" id=\"form-" . $idModal . "\">\n";
        $result .= "<input type=\"hidden\" name=\"_method\" value=\"PUT\">";
        $result .= "<input type=\"hidden\" name=\"_token\" value=\"" . csrf_token() . "\">";

        // Add ID field if dbData is provided
        if ($dbData && (is_object($dbData) ? isset($dbData->id) : isset($dbData['id']))) {
            $idValue = is_object($dbData) ? $dbData->id : $dbData['id'];
            $result .= "<input type=\"hidden\" name=\"id\" value=\"" . $idValue . "\">";
        }

        // If dbData is provided, auto-generate fields from database columns
        if ($dbData) {
            $dbArray = is_object($dbData) ? (array) $dbData : $dbData;

            foreach ($dbArray as $columnName => $columnValue) {
                // Skip excluded fields
                if (in_array($columnName, $excludeFields)) {
                    continue;
                }

                // Check if field is overridden in $fields array
                $fieldOverride = null;
                foreach ($fields as $field) {
                    if (isset($field['name']) && $field['name'] === $columnName) {
                        $fieldOverride = $field;
                        break;
                    }
                }

                if ($fieldOverride) {
                    // Use overridden field settings but keep db value
                    $fieldName = $fieldOverride['name'];
                    $fieldLabel = $fieldOverride['label'] ?? ucfirst(str_replace('_', ' ', $fieldName));
                    $fieldType = $fieldOverride['type'] ?? 'text';
                    $fieldValue = $fieldOverride['value'] ?? $columnValue;
                    $fieldRequired = isset($fieldOverride['required']) && $fieldOverride['required'] ? 'required' : '';
                    $fieldClass = $fieldOverride['class'] ?? 'form-control';
                    $fieldPlaceholder = $fieldOverride['placeholder'] ?? '';
                } else {
                    // Auto-detect field type based on column name and value
                    $fieldName = $columnName;
                    $fieldLabel = ucfirst(str_replace('_', ' ', $fieldName));
                    $fieldValue = $columnValue;
                    $fieldRequired = '';
                    $fieldClass = 'form-control';
                    $fieldPlaceholder = '';

                    // Auto-detect field type
                    if (strpos($fieldName, 'email') !== false) {
                        $fieldType = 'email';
                    } elseif (strpos($fieldName, 'password') !== false) {
                        $fieldType = 'password';
                        $fieldValue = ''; // Don't show password value
                    } elseif (strpos($fieldName, 'phone') !== false || strpos($fieldName, 'tel') !== false) {
                        $fieldType = 'tel';
                    } elseif (strpos($fieldName, 'date') !== false && $fieldName !== 'updated_at' && $fieldName !== 'created_at') {
                        $fieldType = 'date';
                        $fieldValue = $fieldValue ? date('Y-m-d', strtotime($fieldValue)) : '';
                    } elseif (strpos($fieldName, 'time') !== false) {
                        $fieldType = 'time';
                    } elseif (strpos($fieldName, 'url') !== false || strpos($fieldName, 'link') !== false) {
                        $fieldType = 'url';
                    } elseif (strpos($fieldName, 'number') !== false || strpos($fieldName, 'price') !== false || strpos($fieldName, 'amount') !== false) {
                        $fieldType = 'number';
                    } elseif (strlen($fieldValue) > 100 || strpos($fieldName, 'description') !== false || strpos($fieldName, 'content') !== false || strpos($fieldName, 'text') !== false) {
                        $fieldType = 'textarea';
                    } else {
                        $fieldType = 'text';
                    }
                }

                $result .= "<div class=\"mb-3\">\n";
                $result .= "<label for=\"" . $fieldName . "\" class=\"form-label\">" . $fieldLabel . "</label>\n";

                if ($fieldType === 'textarea') {
                    $result .= "<textarea name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" placeholder=\"" . $fieldPlaceholder . "\" " . $fieldRequired . ">" . htmlspecialchars($fieldValue) . "</textarea>\n";
                } elseif ($fieldType === 'select') {
                    $result .= "<select name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" " . $fieldRequired . ">\n";
                    if (isset($fieldOverride['options'])) {
                        foreach ($fieldOverride['options'] as $optionValue => $optionText) {
                            $selected = ($fieldValue == $optionValue) ? 'selected' : '';
                            $result .= "<option value=\"" . $optionValue . "\" " . $selected . ">" . $optionText . "</option>\n";
                        }
                    }
                    $result .= "</select>\n";
                } else {
                    $result .= "<input type=\"" . $fieldType . "\" name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" value=\"" . htmlspecialchars($fieldValue) . "\" placeholder=\"" . $fieldPlaceholder . "\" " . $fieldRequired . ">\n";
                }
                $result .= "</div>\n";
            }
        } else {
            // Generate form fields from $fields array only
            foreach ($fields as $field) {
                $fieldName = $field['name'] ?? '';
                $fieldLabel = $field['label'] ?? ucfirst($fieldName);
                $fieldType = $field['type'] ?? 'text';
                $fieldValue = $field['value'] ?? '';
                $fieldRequired = isset($field['required']) && $field['required'] ? 'required' : '';
                $fieldClass = $field['class'] ?? 'form-control';
                $fieldPlaceholder = $field['placeholder'] ?? '';

                $result .= "<div class=\"mb-3\">\n";
                $result .= "<label for=\"" . $fieldName . "\" class=\"form-label\">" . $fieldLabel . "</label>\n";

                if ($fieldType === 'textarea') {
                    $result .= "<textarea name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" placeholder=\"" . $fieldPlaceholder . "\" " . $fieldRequired . ">" . htmlspecialchars($fieldValue) . "</textarea>\n";
                } elseif ($fieldType === 'select') {
                    $result .= "<select name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" " . $fieldRequired . ">\n";
                    if (isset($field['options'])) {
                        foreach ($field['options'] as $optionValue => $optionText) {
                            $selected = ($fieldValue == $optionValue) ? 'selected' : '';
                            $result .= "<option value=\"" . $optionValue . "\" " . $selected . ">" . $optionText . "</option>\n";
                        }
                    }
                    $result .= "</select>\n";
                } else {
                    $result .= "<input type=\"" . $fieldType . "\" name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" value=\"" . htmlspecialchars($fieldValue) . "\" placeholder=\"" . $fieldPlaceholder . "\" " . $fieldRequired . ">\n";
                }
                $result .= "</div>\n";
            }
        }

        $result .= "</div>\n";
        $result .= "<div class=\"modal-footer\">\n";
        $result .= "<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Zrušit</button>\n";
        $result .= "<button type=\"submit\" class=\"btn btn-" . $type . "\" form=\"form-" . $idModal . "\">" . $buttonText . "</button>\n";
        $result .= "</form>\n";
        $result .= "</div>\n</div>\n</div>\n</div>\n";
        return $result;
    }
}

if (!function_exists('add_modal')) {
    function add_modal($idModal, $heading, $route, $fields = [], $type = "success", $buttonText = "Přidat")
    {
        $result = "";
        $result .= "<div class=\"modal fade\" id=\"" . $idModal . "\">\n";
        $result .= "<div class=\"modal-dialog\">\n";
        $result .= " <div class=\"modal-content\">\n";
        $result .= "<div class=\"modal-header\">\n";
        $result .= "<h4 class=\"modal-title\">" . $heading . "</h4>\n";
        $result .= "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>\n";
        $result .= "</div>\n";
        $result .= "<div class=\"modal-body\">\n";
        $result .= "<form method=\"POST\" action=\"" . $route . "\" id=\"form-" . $idModal . "\" enctype='multipart/form-data'>\n";
        $result .= "<input type=\"hidden\" name=\"_token\" value=\"" . csrf_token() . "\">";

        // Generate form fields
        foreach ($fields as $field) {
            $fieldName = $field['name'] ?? '';
            $fieldLabel = $field['label'] ?? ucfirst($fieldName);
            $fieldType = $field['type'] ?? 'text';
            $fieldValue = $field['value'] ?? '';
            $fieldRequired = isset($field['required']) && $field['required'] ? 'required' : '';
            $fieldClass = $field['class'] ?? 'form-control';
            $fieldPlaceholder = $field['placeholder'] ?? '';

            $result .= "<div class=\"mb-3\">\n";
            $result .= "<label for=\"" . $fieldName . "\" class=\"form-label\">" . $fieldLabel . "</label>\n";

            if ($fieldType === 'textarea') {
                $result .= "<textarea name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" placeholder=\"" . $fieldPlaceholder . "\" " . $fieldRequired . ">" . htmlspecialchars($fieldValue) . "</textarea>\n";
            } elseif ($fieldType === 'select') {
                $result .= "<select name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" " . $fieldRequired . " >\n";
                if (isset($field['options'])) {
                    foreach ($field['options'] as $optionValue => $optionText) {
                        $selected = ($fieldValue == $optionValue) ? 'selected' : '';
                        $result .= "<option value=\"" . $optionValue . "\" " . $selected . ">" . $optionText . "</option>\n";
                    }
                }
                $result .= "</select>\n";
            } elseif ($fieldType === 'select-multiple') {
                $result .= "<select name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" " . $fieldRequired . " multiple>\n";
                if (isset($field['options'])) {
                    foreach ($field['options'] as $optionValue => $optionText) {
                        $selected = ($fieldValue == $optionValue) ? 'selected' : '';
                        $result .= "<option value=\"" . $optionValue . "\" " . $selected . ">" . $optionText . "</option>\n";
                    }
                }
                $result .= "</select>\n";
            } else {
                $result .= "<input type=\"" . $fieldType . "\" name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" value=\"" . htmlspecialchars($fieldValue) . "\" placeholder=\"" . $fieldPlaceholder . "\" " . $fieldRequired . ">\n";
            }
            $result .= "</div>\n";
        }

        $result .= "</div>\n";
        $result .= "<div class=\"modal-footer\">\n";
        $result .= "<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Zrušit</button>\n";
        $result .= "<button type=\"submit\" class=\"btn btn-" . $type . "\" form=\"form-" . $idModal . "\">" . $buttonText . "</button>\n";
        $result .= "</form>\n";
        $result .= "</div>\n</div>\n</div>\n</div>\n";
        return $result;
    }
}
if (!function_exists('edit_modal2')) {
    function edit_modal2($idModal, $heading, $route, $fields = [], $type = "alert", $buttonText = "Přidat")
    {
        $result = "";
        $result .= "<div class=\"modal fade\" id=\"" . $idModal . "\">\n";
        $result .= "<div class=\"modal-dialog\">\n";
        $result .= " <div class=\"modal-content\">\n";
        $result .= "<div class=\"modal-header\">\n";
        $result .= "<h4 class=\"modal-title\">" . $heading . "</h4>\n";
        $result .= "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>\n";
        $result .= "</div>\n";
        $result .= "<div class=\"modal-body\">\n";
        $result .= "<form method=\"POST\" action=\"" . $route . "\" id=\"form-" . $idModal . "\" enctype='multipart/form-data'>\n";
        $result .= "<input type=\"hidden\" name=\"_token\" value=\"" . csrf_token() . "\">";

        // Generate form fields
        foreach ($fields as $field) {
            $fieldName = $field['name'] ?? '';
            $fieldLabel = $field['label'] ?? ucfirst($fieldName);
            $fieldType = $field['type'] ?? 'text';
            $fieldValue = $field['value'] ?? '';
            $fieldRequired = isset($field['required']) && $field['required'] ? 'required' : '';
            $fieldClass = $field['class'] ?? 'form-control';
            $fieldPlaceholder = $field['placeholder'] ?? '';

            $result .= "<div class=\"mb-3\">\n";
            $result .= "<label for=\"" . $fieldName . "\" class=\"form-label\">" . $fieldLabel . "</label>\n";

            if ($fieldType === 'textarea') {
                $result .= "<textarea name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" placeholder=\"" . $fieldPlaceholder . "\" " . $fieldRequired . ">" . htmlspecialchars($fieldValue) . "</textarea>\n";
            } elseif ($fieldType === 'select') {
                $result .= "<select name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" " . $fieldRequired . " >\n";
                if (isset($field['options'])) {
                    foreach ($field['options'] as $optionValue => $optionText) {
                        $selected = ($fieldValue == $optionValue) ? 'selected' : '';
                        $result .= "<option value=\"" . $optionValue . "\" " . $selected . ">" . $optionText . "</option>\n";
                    }
                }
                $result .= "</select>\n";
            } elseif ($fieldType === 'select-multiple') {
                $result .= "<select name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" " . $fieldRequired . " multiple>\n";
                if (isset($field['options'])) {
                    foreach ($field['options'] as $optionValue => $optionText) {
                        $selected = ($fieldValue == $optionValue) ? 'selected' : '';
                        $result .= "<option value=\"" . $optionValue . "\" " . $selected . ">" . $optionText . "</option>\n";
                    }
                }
                $result .= "</select>\n";
            } else {
                $result .= "<input type=\"" . $fieldType . "\" name=\"" . $fieldName . "\" id=\"" . $fieldName . "\" class=\"" . $fieldClass . "\" value=\"" . htmlspecialchars($fieldValue) . "\" placeholder=\"" . $fieldPlaceholder . "\" " . $fieldRequired . ">\n";
            }
            $result .= "</div>\n";
        }

        $result .= "</div>\n";
        $result .= "<div class=\"modal-footer\">\n";
        $result .= "<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Zrušit</button>\n";
        $result .= "<button type=\"submit\" class=\"btn btn-" . $type . "\" form=\"form-" . $idModal . "\">" . $buttonText . "</button>\n";
        $result .= "</form>\n";
        $result .= "</div>\n</div>\n</div>\n</div>\n";
        return $result;
    }
}
?>
