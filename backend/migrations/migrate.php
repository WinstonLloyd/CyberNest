<?php
/**
 * Database Migration Script
 * Adds file upload support for OSINT challenges
 */

require_once __DIR__ . '/../config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "Starting migration: Adding file upload support for OSINT challenges...\n";
    
    // Read migration SQL
    $migrationFile = __DIR__ . '/database.sql';
    if (!file_exists($migrationFile)) {
        throw new Exception("Migration file not found: $migrationFile");
    }
    
    $sql = file_get_contents($migrationFile);
    
    // Split SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    $db->beginTransaction();
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            echo "Executing: $statement\n";
            $db->exec($statement);
        }
    }
    
    $db->commit();
    
    echo "Migration completed successfully!\n";
    echo "Added columns: file_path, original_filename, file_size\n";
    echo "OSINT challenges can now have file uploads!\n";
    
} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    echo "Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>
