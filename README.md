# Object Storage Service for Laravel

AliCloud Cloud Object Storage Service For Laravel Framework

### Init
```php
use Illuminate\Support\Facades\Storage;

$objStorage = Storage::disk('oss');
```

### Write

Upload a local file to remote OSS
```php
Storage::disk('oss')->putFile('remote/path', 'local/path/file_name.ext');
Storage::disk('oss')->putFileAs('remote/path', 'local/path/file_name.ext', 'new_file_name.ext');
```

Streaming a file content and write into OSS as a file
```php
Storage::disk('oss')->put("dir/path/file.txt", file_get_contents("/local/path/file.txt"));
$fp = fopen("/local/path/file.txt","r");
Storage::disk('oss')->put("dir/path/file.txt", $fp);
fclose($fp);
```

Prepend or append new content to a file
```php
Storage::disk('oss')->prepend('remote/path/file_name', 'Bring your idea to life in no time.'); 
Storage::disk('oss')->append('remote/path/file_name', 'Bring your idea to life in no time.');
```

### Read

```php
Storage::disk('oss')->url('remote/path/file_name');
Storage::disk('oss')->get('remote/path/file_name'); 
Storage::disk('oss')->exists('remote/path/file_name'); 
Storage::disk('oss')->size('remote/path/file_name'); 
Storage::disk('oss')->lastModified('remote/path/file_name');
```

### Delete

```php
Storage::disk('oss')->delete('remote/path/file_name');
Storage::disk('oss')->delete(['remote/path/file_name_one', 'remote/path/file_name_two']);
```

### File Actions

```php
Storage::disk('oss')->copy('remote/path/file_name', 'remote/path/file_name_clone');
Storage::disk('oss')->move('remote/path/file_name', 'remote/path/new_file_name');
Storage::disk('oss')->rename('remote/path/file_name', 'remote/path/new_file_name');
```

### Folder Actions

```php
Storage::disk('oss')->makeDirectory('remote/path/folder_name');
Storage::disk('oss')->deleteDirectory('remote/path/folder_name');
Storage::disk('oss')->files('remote/path/folder');
Storage::disk('oss')->allFiles('remote/path/folder');
Storage::disk('oss')->directories('remote/path/folder');
Storage::disk('oss')->allDirectories('remote/path/folder');
```