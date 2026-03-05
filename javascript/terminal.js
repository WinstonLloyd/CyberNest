class LinuxConsole {
    constructor() {
        this.commandHistory = [];
        this.commandCount = 0;
        this.currentDirectory = '~';
        this.loadFileSystem();
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        const commandInput = document.getElementById('commandInput');
        const executeBtn = document.getElementById('executeBtn');
        const clearHistoryBtn = document.getElementById('clearHistory');
        const quickCmdButtons = document.querySelectorAll('.quick-cmd');

        commandInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.executeCommand();
            }
        });

        executeBtn.addEventListener('click', () => this.executeCommand());

        clearHistoryBtn.addEventListener('click', () => this.clearHistory());

        quickCmdButtons.forEach(button => {
            button.addEventListener('click', () => {
                const cmd = button.getAttribute('data-cmd');
                commandInput.value = cmd;
                this.executeCommand();
            });
        });

        commandInput.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                this.navigateHistory(-1);
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                this.navigateHistory(1);
            }
        });

        commandInput.focus();
        
        this.updatePrompt();
    }

    updatePrompt() {
        const promptElement = document.getElementById('prompt');
        const displayPath = this.currentDirectory === '~' ? '~' : this.currentDirectory;
        promptElement.textContent = `${displayPath}$`;
    }

    loadFileSystem() {
        const saved = localStorage.getItem('linuxConsoleFileSystem');
        if (saved) {
            try {
                this.simulatedFileSystem = JSON.parse(saved);
            } catch (e) {
                console.error('Failed to load file system from localStorage:', e);
                this.simulatedFileSystem = this.createSimulatedFileSystem();
            }
        } else {
            this.simulatedFileSystem = this.createSimulatedFileSystem();
            this.saveFileSystem();
        }
    }

    saveFileSystem() {
        try {
            localStorage.setItem('linuxConsoleFileSystem', JSON.stringify(this.simulatedFileSystem));
        } catch (e) {
            console.error('Failed to save file system to localStorage:', e);
        }
    }

    createSimulatedFileSystem() {
        return {
            '~': {
                type: 'directory',
                contents: {
                    'documents': { type: 'directory', contents: {} },
                    'downloads': { type: 'directory', contents: {} },
                    'desktop': { type: 'directory', contents: {} },
                    'projects': { type: 'directory', contents: {} },
                    'readme.txt': { type: 'file', content: 'Welcome to Linux Console Simulator!' },
                    'config.json': { type: 'file', content: '{\n  "name": "Linux Console",\n  "version": "1.0.0"\n}' }
                }
            }
        };
    }

    executeCommand() {
        const commandInput = document.getElementById('commandInput');
        const command = commandInput.value.trim();
        
        if (!command) return;

        this.addToHistory(command);
        this.commandCount++;
        this.updateStats();

        this.displayCommand(command);

        this.processCommand(command);

        commandInput.value = '';
        this.historyIndex = -1;
    }

    processCommand(command) {
        const parts = command.split(' ');
        const cmd = parts[0].toLowerCase();
        const args = parts.slice(1);

        this.updateStatus('Processing...');

        setTimeout(() => {
            switch (cmd) {
                case 'help':
                    this.showHelp();
                    break;
                case 'man':
                    this.showManPage(args);
                    break;
                case 'ls':
                    this.listDirectory(args);
                    break;
                case 'pwd':
                    this.printWorkingDirectory();
                    break;
                case 'cd':
                    this.changeDirectory(args);
                    break;
                case 'whoami':
                    this.displayOutput('user');
                    break;
                case 'date':
                    this.displayOutput(new Date().toString());
                    break;
                case 'uname':
                    this.showUname(args);
                    break;
                case 'clear':
                    this.clearTerminal();
                    break;
                case 'echo':
                    this.displayOutput(args.join(' '));
                    break;
                case 'cat':
                    this.catFile(args);
                    break;
                case 'mkdir':
                    this.makeDirectory(args);
                    break;
                case 'rmdir':
                    this.removeDirectory(args);
                    break;
                case 'touch':
                    this.touchFile(args);
                    break;
                case 'rm':
                    this.removeFile(args);
                    break;
                case 'cp':
                    this.copyFile(args);
                    break;
                case 'mv':
                    this.moveFile(args);
                    break;
                case 'head':
                    this.headFile(args);
                    break;
                case 'tail':
                    this.tailFile(args);
                    break;
                case 'grep':
                    this.grepFile(args);
                    break;
                case 'sort':
                    this.sortFile(args);
                    break;
                case 'uniq':
                    this.uniqFile(args);
                    break;
                case 'wc':
                    this.wcFile(args);
                    break;
                case 'diff':
                    this.diffFiles(args);
                    break;
                case 'find':
                    this.findFiles(args);
                    break;
                case 'locate':
                    this.locateFile(args);
                    break;
                case 'tree':
                    this.showTree(args);
                    break;
                case 'du':
                    this.showDiskUsage(args);
                    break;
                case 'ps':
                    this.showProcesses();
                    break;
                case 'top':
                    this.showTop();
                    break;
                case 'df':
                    this.showDiskSpace(args);
                    break;
                case 'free':
                    this.showMemory(args);
                    break;
                case 'uptime':
                    this.showUptime();
                    break;
                case 'wget':
                    this.wgetFile(args);
                    break;
                case 'display':
                    this.displayImage(args);
                    break;
                default:
                    this.displayOutput(`Command not found: ${cmd}. Type 'help' for available commands.`);
            }
            this.updateStatus('Ready');
        }, 300);
    }

    showManPage(args) {
        if (!args[0]) {
            this.displayOutput('What manual page do you want?');
            this.displayOutput('For example: man ls, man cd, man mkdir');
            return;
        }

        const command = args[0].toLowerCase();
        const manPages = {
            'ls': `LS(1)                           User Commands                          LS(1)

NAME
       ls - list directory contents

SYNOPSIS
       ls [OPTION]... [FILE]...

DESCRIPTION
       List information about the FILEs (the current directory by default).

EXAMPLES
       ls              - List files in current directory
       ls -la          - List all files with details
       ls /path/to/dir - List files in specific directory`,
            
            'cd': `CD(1)                           User Commands                          CD(1)

NAME
       cd - change directory

SYNOPSIS
       cd [DIRECTORY]

DESCRIPTION
       Change the current working directory.

EXAMPLES
       cd              - Change to home directory
       cd dirname       - Change to subdirectory
       cd..            - Go to parent directory
       cd ..           - Go to parent directory`,
            
            'pwd': `PWD(1)                          User Commands                          PWD(1)

NAME
       pwd - print working directory

SYNOPSIS
       pwd

DESCRIPTION
       Print the full filename of the current working directory.`,
            
            'mkdir': `MKDIR(1)                       User Commands                          MKDIR(1)

NAME
       mkdir - make directories

SYNOPSIS
       mkdir [OPTION]... DIRECTORY...

DESCRIPTION
       Create the DIRECTORY(ies), if they do not already exist.

EXAMPLES
       mkdir dirname    - Create a new directory
       mkdir -p path/to/dir - Create directory with parents`,
            
            'rmdir': `RMDIR(1)                       User Commands                          RMDIR(1)

NAME
       rmdir - remove empty directories

SYNOPSIS
       rmdir [OPTION]... DIRECTORY...

DESCRIPTION
       Remove the DIRECTORY(ies), if they are empty.

EXAMPLES
       rmdir dirname    - Remove empty directory
       rmdir path/to/dir - Remove empty subdirectory`,
            
            'touch': `TOUCH(1)                       User Commands                          TOUCH(1)

NAME
       touch - change file timestamps

SYNOPSIS
       touch [OPTION]... FILE...

DESCRIPTION
       Update the access and modification times of each FILE to the current time.
       A FILE argument that does not exist is created empty.

EXAMPLES
       touch filename  - Create a new empty file`,
            
            'rm': `RM(1)                           User Commands                          RM(1)

NAME
       rm - remove files or directories

SYNOPSIS
       rm [OPTION]... FILE...

DESCRIPTION
       Remove (unlink) the FILE(s).

EXAMPLES
       rm filename     - Remove a file
       rm -r dirname   - Remove directory and contents`,
            
            'cat': `CAT(1)                          User Commands                          CAT(1)

NAME
       cat - concatenate files and print on the standard output

SYNOPSIS
       cat [FILE]...

DESCRIPTION
       Concatenate FILE(s) to standard output.

EXAMPLES
       cat filename    - Display file contents
       cat file1 file2 - Display multiple files`,
            
            'echo': `ECHO(1)                        User Commands                          ECHO(1)

NAME
       echo - display a line of text

SYNOPSIS
       echo [SHORT-OPTION]... [STRING]...

DESCRIPTION
       Echo the STRING(s) to standard output.

EXAMPLES
       echo "Hello"    - Display text
       echo $PATH      - Display environment variable`,
            
            'clear': `CLEAR(1)                       User Commands                          CLEAR(1)

NAME
       clear - clear the terminal screen

SYNOPSIS
       clear

DESCRIPTION
       Clear the terminal screen and move cursor to top-left corner.`,
            
            'whoami': `WHOAMI(1)                     User Commands                          WHOAMI(1)

NAME
       whoami - print effective userid

SYNOPSIS
       whoami

DESCRIPTION
       Print the user name associated with the current effective user ID.`,
            
            'date': `DATE(1)                        User Commands                          DATE(1)

NAME
       date - print or set the system date and time

SYNOPSIS
       date [OPTION]... [+FORMAT]

DESCRIPTION
       Display the current time in the given FORMAT.

EXAMPLES
       date            - Show current date and time
       date +"%Y-%m-%d" - Show date in YYYY-MM-DD format`,
            
            'uname': `UNAME(1)                       User Commands                          UNAME(1)

NAME
       uname - print system information

SYNOPSIS
       uname [OPTION]...

DESCRIPTION
       Print certain system information.

EXAMPLES
       uname           - Show kernel name
       uname -a        - Show all system information`,
            
            'ps': `PS(1)                           User Commands                          PS(1)

NAME
       ps - report a snapshot of the current processes

SYNOPSIS
       ps [OPTIONS]

DESCRIPTION
       Display information about active processes.

EXAMPLES
       ps              - Show processes from current terminal
       ps aux          - Show all processes`,
            
            'top': `TOP(1)                          User Commands                          TOP(1)

NAME
       top - display Linux processes

SYNOPSIS
       top [OPTIONS]

DESCRIPTION
       Display and update sorted information about processes.`,
            
            'df': `DF(1)                           User Commands                          DF(1)

NAME
       df - report file system disk space usage

SYNOPSIS
       df [OPTION]... [FILE]...

DESCRIPTION
       Display information about the file system on which each FILE resides.`,
            
            'free': `FREE(1)                        User Commands                          FREE(1)

NAME
       free - Display amount of free and used memory in the system

SYNOPSIS
       free [OPTIONS]

DESCRIPTION
       Display the total amount of free and used physical and swap memory.`,
            
            'uptime': `UPTIME(1)                     User Commands                          UPTIME(1)

NAME
       uptime - tell how long the system has been running

SYNOPSIS
       uptime

DESCRIPTION
       Display how long the system has been running, number of users, and system load.`
        };

        if (manPages[command]) {
            this.displayOutput(manPages[command]);
        } else {
            this.displayOutput(`No manual entry for ${command}`);
            this.displayOutput(`Type 'help' to see available commands.`);
        }
    }

    showHelp() {
        const helpText = `
            Available Commands:

            File System:
              ls, ls -la    - List directory contents
              pwd            - Print working directory
              cd <dir>       - Change directory
              mkdir <dir>    - Create directory
              rmdir <dir>    - Remove empty directory
              rm <file>      - Remove file
              cp <src> <dst> - Copy files
              mv <src> <dst> - Move/rename files
              touch <file>    - Create empty file
              find <path> -name <pattern> - Search files
              locate <name>  - Find files by name
              tree [path]     - Display directory tree
              du -sh [path]  - Show disk usage
              df -h           - Show disk space
              wget <url>     - Download file from URL
              display <img>  - Display image files

            File Content:
              cat <file>      - Display file contents
              head -n <N> <file> - Show first N lines
              tail -n <N> <file> - Show last N lines
              grep <pattern> <file> - Search text
              sort <file>     - Sort lines
              uniq <file>      - Remove duplicates
              wc <file>       - Count lines/words
              diff <file1> <file2> - Compare files

            System Info:
              whoami          - Display current user
              date            - Show current date and time
              uname [-a]      - Show system information
              uptime          - Show system uptime
              free -h         - Show memory usage
              ps              - Show running processes
              top             - Show system processes

            Utilities:
              help            - Show this help message
              man <cmd>       - Show manual page for a command
              clear           - Clear terminal screen
              echo <text>     - Display text

            Navigation:
              ↑/↓ arrows      - Navigate command history
              Enter           - Execute command
        `;
        this.displayOutput(helpText.trim());
    }

    listDirectory(args) {
        const dir = args[0] || this.currentDirectory;
        const path = this.resolvePath(dir);
        
        let node;
        
        if (path.includes('/')) {
            const parts = path.split('/');
            let current = this.simulatedFileSystem;
            
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    this.displayOutput(`ls: cannot access '${dir}': No such file or directory`);
                    return;
                }
            }
            node = { type: 'directory', contents: current };
        } else {
            if (!this.simulatedFileSystem[path]) {
                this.displayOutput(`ls: cannot access '${dir}': No such file or directory`);
                return;
            }
            node = this.simulatedFileSystem[path];
        }
        
        if (node.type !== 'directory') {
            this.displayOutput(`${dir} is not a directory`);
            return;
        }

        const contents = Object.keys(node.contents);
        if (contents.length === 0) {
            this.displayOutput('(empty directory)');
            return;
        }

        const output = contents.map(item => {
            const itemNode = node.contents[item];
            const prefix = itemNode.type === 'directory' ? 'd' : '-';
            const permissions = itemNode.type === 'directory' ? 'rwxr-xr-x' : 'rw-r--r--';
            return `${prefix}${permissions} 1 user user 0 ${new Date().toLocaleDateString()} ${item}`;
        }).join('\n');

        this.displayOutput(output);
    }

    printWorkingDirectory() {
        this.displayOutput(this.currentDirectory);
    }

    changeDirectory(args) {
        if (!args[0]) {
            this.currentDirectory = '~';
            this.updatePrompt();
            this.displayOutput('');
            return;
        }

        const targetDir = args[0];
        
        if (targetDir === '..' || targetDir === 'cd..') {
            if (this.currentDirectory === '~') {
                this.displayOutput('cd: Already at home directory');
                return;
            }
            
            const parts = this.currentDirectory.split('/');
            parts.pop();
            this.currentDirectory = parts.join('/') || '~';
            this.updatePrompt();
            this.displayOutput('');
            return;
        }

        const newPath = this.resolvePath(targetDir);
        
        if (newPath.includes('/')) {
            const parts = newPath.split('/');
            let current = this.simulatedFileSystem;
            
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    this.displayOutput(`cd: ${targetDir}: No such file or directory`);
                    return;
                }
            }
            
            this.currentDirectory = newPath;
            this.updatePrompt();
            this.displayOutput('');
            return;
        }
        
        let currentDirContents;
        if (this.currentDirectory === '~') {
            currentDirContents = this.simulatedFileSystem['~'].contents;
        } else {
            const parts = this.currentDirectory.split('/');
            let current = this.simulatedFileSystem;
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                }
            }
            currentDirContents = current;
        }
        
        if (!currentDirContents[newPath]) {
            this.displayOutput(`cd: ${targetDir}: No such file or directory`);
            return;
        }

        if (currentDirContents[newPath].type !== 'directory') {
            this.displayOutput(`cd: ${targetDir}: Not a directory`);
            return;
        }

        if (this.currentDirectory === '~') {
            this.currentDirectory = `~/${newPath}`;
        } else {
            this.currentDirectory = `${this.currentDirectory}/${newPath}`;
        }
        this.updatePrompt();
        this.displayOutput('');
    }

    resolvePath(path) {
        if (path === '~' || path === this.currentDirectory) return this.currentDirectory;
        if (path === '/') return '~';
        if (path === '..') {
            const parts = this.currentDirectory.split('/');
            parts.pop();
            return parts.join('/') || '~';
        }
        if (path.startsWith('/')) return '~' + path;
        if (path.startsWith('./')) return this.currentDirectory + path.substring(1);
        if (this.currentDirectory === '~') return '~/' + path;
        return this.currentDirectory + '/' + path;
    }

    catFile(args) {
        if (!args[0]) {
            this.displayOutput('cat: missing file operand');
            return;
        }

        const filePath = this.resolvePath(args[0]);
        const content = this.getFileContent(filePath);
        
        if (content === null) {
            this.displayOutput(`cat: ${args[0]}: No such file or directory`);
            return;
        }

        const filename = args[0].toLowerCase();
        const imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp', '.webp', '.svg', '.ico'];
        const isImage = imageExtensions.some(ext => filename.endsWith(ext));

        if (isImage && content.includes('Downloaded from:')) {
            const urlMatch = content.match(/Downloaded from: (.+)/);
            const imageUrl = urlMatch ? urlMatch[1] : null;
            
            if (imageUrl) {
                const output = document.getElementById('output');
                const imageDiv = document.createElement('div');
                imageDiv.className = 'fade-in mb-4';
                imageDiv.innerHTML = `
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <div class="text-green-400 mb-2">📷 Image: ${args[0]}</div>
                        <img src="${imageUrl}" alt="${args[0]}" class="max-w-full max-h-96 rounded-lg shadow-lg" 
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                             style="display: block;">
                        <div class="text-red-400" style="display: none;">
                            ⚠️ Failed to load image: ${imageUrl}
                        </div>
                        <div class="text-gray-400 text-sm mt-2">
                            Original URL: <a href="${imageUrl}" target="_blank" class="text-blue-400 hover:text-blue-300">${imageUrl}</a>
                        </div>
                    </div>
                `;
                output.appendChild(imageDiv);
                this.scrollToBottom();
                return;
            }
        }

        this.displayOutput(content);
    }

    makeDirectory(args) {
        if (!args[0]) {
            this.displayOutput('mkdir: missing operand');
            return;
        }

        const dirPath = this.resolvePath(args[0]);
        let parentPath;
        let dirName;

        if (dirPath.includes('/')) {
            parentPath = dirPath.substring(0, dirPath.lastIndexOf('/'));
            dirName = dirPath.substring(dirPath.lastIndexOf('/') + 1);
        } else {
            parentPath = this.currentDirectory;
            dirName = dirPath;
        }
        
        if (!parentPath || parentPath === '') {
            parentPath = '~';
        }
        
        let parentDir;
        if (parentPath.includes('/')) {
            const parts = parentPath.split('/');
            let current = this.simulatedFileSystem;
            
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    this.displayOutput(`mkdir: cannot create directory '${args[0]}': No such file or directory`);
                    return;
                }
            }
            parentDir = current;
        } else {
            if (!this.simulatedFileSystem[parentPath]) {
                this.displayOutput(`mkdir: cannot create directory '${args[0]}': No such file or directory`);
                return;
            }
            parentDir = this.simulatedFileSystem[parentPath].contents;
        }

        parentDir[dirName] = {
            type: 'directory',
            contents: {}
        };
        this.saveFileSystem();
        this.displayOutput('');
    }

    removeDirectory(args) {
        if (!args[0]) {
            this.displayOutput('rmdir: missing operand');
            return;
        }

        const dirPath = this.resolvePath(args[0]);
        let parentPath;
        let dirName;

        if (dirPath.includes('/')) {
            parentPath = dirPath.substring(0, dirPath.lastIndexOf('/'));
            dirName = dirPath.substring(dirPath.lastIndexOf('/') + 1);
        } else {
            parentPath = this.currentDirectory;
            dirName = dirPath;
        }
        
        if (!parentPath || parentPath === '') {
            parentPath = '~';
        }
        
        let parentDir;
        if (parentPath.includes('/')) {
            const parts = parentPath.split('/');
            let current = this.simulatedFileSystem;
            
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    this.displayOutput(`rmdir: failed to remove '${args[0]}': No such file or directory`);
                    return;
                }
            }
            parentDir = current;
        } else {
            if (!this.simulatedFileSystem[parentPath]) {
                this.displayOutput(`rmdir: failed to remove '${args[0]}': No such file or directory`);
                return;
            }
            parentDir = this.simulatedFileSystem[parentPath].contents;
        }
        
        if (!parentDir[dirName]) {
            this.displayOutput(`rmdir: failed to remove '${args[0]}': No such file or directory`);
            return;
        }

        if (parentDir[dirName].type !== 'directory') {
            this.displayOutput(`rmdir: failed to remove '${args[0]}': Not a directory`);
            return;
        }

        const contents = Object.keys(parentDir[dirName].contents);
        if (contents.length > 0) {
            this.displayOutput(`rmdir: failed to remove '${args[0]}': Directory not empty`);
            return;
        }

        delete parentDir[dirName];
        this.saveFileSystem();
        this.displayOutput('');
    }

    touchFile(args) {
        if (!args[0]) {
            this.displayOutput('touch: missing file operand');
            return;
        }

        const filePath = this.resolvePath(args[0]);
        let parentPath;
        let fileName;

        if (filePath.includes('/')) {
            parentPath = filePath.substring(0, filePath.lastIndexOf('/'));
            fileName = filePath.substring(filePath.lastIndexOf('/') + 1);
        } else {
            parentPath = this.currentDirectory;
            fileName = filePath;
        }
        
        if (!parentPath || parentPath === '') {
            parentPath = '~';
        }
        
        let parentDir;
        if (parentPath.includes('/')) {
            const parts = parentPath.split('/');
            let current = this.simulatedFileSystem;
            
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    this.displayOutput(`touch: cannot create file '${args[0]}': No such file or directory`);
                    return;
                }
            }
            parentDir = current;
        } else {
            if (!this.simulatedFileSystem[parentPath]) {
                this.displayOutput(`touch: cannot create file '${args[0]}': No such file or directory`);
                return;
            }
            parentDir = this.simulatedFileSystem[parentPath].contents;
        }

        parentDir[fileName] = {
            type: 'file',
            content: ''
        };
        this.saveFileSystem();
        this.displayOutput('');
    }

    copyFile(args) {
        if (args.length < 2) {
            this.displayOutput('cp: missing file operand');
            return;
        }

        const srcPath = this.resolvePath(args[0]);
        const dstPath = this.resolvePath(args[1]);
        
        let srcFile;
        let srcParentPath;
        let srcFileName;

        if (srcPath.includes('/')) {
            srcParentPath = srcPath.substring(0, srcPath.lastIndexOf('/'));
            srcFileName = srcPath.substring(srcPath.lastIndexOf('/') + 1);
        } else {
            srcParentPath = this.currentDirectory;
            srcFileName = srcPath;
        }

        let srcParentDir;
        if (srcParentPath.includes('/')) {
            const parts = srcParentPath.split('/');
            let current = this.simulatedFileSystem;
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    this.displayOutput(`cp: cannot stat '${args[0]}': No such file or directory`);
                    return;
                }
            }
            srcParentDir = current;
        } else {
            if (!this.simulatedFileSystem[srcParentPath]) {
                this.displayOutput(`cp: cannot stat '${args[0]}': No such file or directory`);
                return;
            }
            srcParentDir = this.simulatedFileSystem[srcParentPath].contents;
        }

        srcFile = srcParentDir[srcFileName];
        if (!srcFile) {
            this.displayOutput(`cp: cannot stat '${args[0]}': No such file or directory`);
            return;
        }

        let dstParentPath;
        let dstFileName;

        if (dstPath.includes('/')) {
            dstParentPath = dstPath.substring(0, dstPath.lastIndexOf('/'));
            dstFileName = dstPath.substring(dstPath.lastIndexOf('/') + 1);
        } else {
            dstParentPath = this.currentDirectory;
            dstFileName = dstPath;
        }

        let dstParentDir;
        if (dstParentPath.includes('/')) {
            const parts = dstParentPath.split('/');
            let current = this.simulatedFileSystem;
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    this.displayOutput(`cp: cannot create regular file '${args[1]}': No such file or directory`);
                    return;
                }
            }
            dstParentDir = current;
        } else {
            if (!this.simulatedFileSystem[dstParentPath]) {
                this.displayOutput(`cp: cannot create regular file '${args[1]}': No such file or directory`);
                return;
            }
            dstParentDir = this.simulatedFileSystem[dstParentPath].contents;
        }

        dstParentDir[dstFileName] = {
            type: srcFile.type,
            content: srcFile.content,
            contents: srcFile.contents ? {...srcFile.contents} : {}
        };

        this.saveFileSystem();
        this.displayOutput('');
    }

    moveFile(args) {
        if (args.length < 2) {
            this.displayOutput('mv: missing file operand');
            return;
        }

        this.copyFile(args);
        const srcPath = this.resolvePath(args[0]);
        let srcParentPath;
        let srcFileName;

        if (srcPath.includes('/')) {
            srcParentPath = srcPath.substring(0, srcPath.lastIndexOf('/'));
            srcFileName = srcPath.substring(srcPath.lastIndexOf('/') + 1);
        } else {
            srcParentPath = this.currentDirectory;
            srcFileName = srcPath;
        }

        let srcParentDir;
        if (srcParentPath.includes('/')) {
            const parts = srcParentPath.split('/');
            let current = this.simulatedFileSystem;
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                }
            }
            srcParentDir = current;
        } else {
            srcParentDir = this.simulatedFileSystem[srcParentPath].contents;
        }

        if (srcParentDir && srcParentDir[srcFileName]) {
            delete srcParentDir[srcFileName];
            this.saveFileSystem();
        }
    }

    headFile(args) {
        if (args.length === 0) {
            this.displayOutput('head: missing file operand');
            return;
        }

        let lines = 10;
        let filename;

        if (args[0] === '-n' && args.length >= 2) {
            lines = parseInt(args[1]) || 10;
            filename = args[2];
        } else {
            filename = args[0];
        }

        const filePath = this.resolvePath(filename);
        const content = this.getFileContent(filePath);
        
        if (content === null) {
            this.displayOutput(`head: cannot open '${filename}' for reading: No such file or directory`);
            return;
        }

        const fileLines = content.split('\n');
        const headLines = fileLines.slice(0, lines);
        this.displayOutput(headLines.join('\n'));
    }

    tailFile(args) {
        if (args.length === 0) {
            this.displayOutput('tail: missing file operand');
            return;
        }

        let lines = 10;
        let filename;

        if (args[0] === '-n' && args.length >= 2) {
            lines = parseInt(args[1]) || 10;
            filename = args[2];
        } else {
            filename = args[0];
        }

        const filePath = this.resolvePath(filename);
        const content = this.getFileContent(filePath);
        
        if (content === null) {
            this.displayOutput(`tail: cannot open '${filename}' for reading: No such file or directory`);
            return;
        }

        const fileLines = content.split('\n');
        const tailLines = fileLines.slice(-lines);
        this.displayOutput(tailLines.join('\n'));
    }

    getFileContent(filePath) {
        let parentPath;
        let fileName;

        if (filePath.includes('/')) {
            parentPath = filePath.substring(0, filePath.lastIndexOf('/'));
            fileName = filePath.substring(filePath.lastIndexOf('/') + 1);
        } else {
            parentPath = this.currentDirectory;
            fileName = filePath;
        }

        let parentDir;
        if (parentPath.includes('/')) {
            const parts = parentPath.split('/');
            let current = this.simulatedFileSystem;
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    return null;
                }
            }
            parentDir = current;
        } else {
            if (!this.simulatedFileSystem[parentPath]) {
                return null;
            }
            parentDir = this.simulatedFileSystem[parentPath].contents;
        }

        const file = parentDir[fileName];
        if (!file || file.type !== 'file') {
            return null;
        }

        return file.content;
    }

    removeFile(args) {
        if (!args[0]) {
            this.displayOutput('rm: missing operand');
            return;
        }

        const filePath = this.resolvePath(args[0]);
        let parentPath;
        let fileName;

        if (filePath.includes('/')) {
            parentPath = filePath.substring(0, filePath.lastIndexOf('/'));
            fileName = filePath.substring(filePath.lastIndexOf('/') + 1);
        } else {
            parentPath = this.currentDirectory;
            fileName = filePath;
        }
        
        if (!parentPath || parentPath === '') {
            parentPath = '~';
        }
        
        let parentDir;
        if (parentPath.includes('/')) {
            const parts = parentPath.split('/');
            let current = this.simulatedFileSystem;
            
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    this.displayOutput(`rm: cannot remove '${args[0]}': No such file or directory`);
                    return;
                }
            }
            parentDir = current;
        } else {
            if (!this.simulatedFileSystem[parentPath]) {
                this.displayOutput(`rm: cannot remove '${args[0]}': No such file or directory`);
                return;
            }
            parentDir = this.simulatedFileSystem[parentPath].contents;
        }
        
        if (!parentDir[fileName]) {
            this.displayOutput(`rm: cannot remove '${args[0]}': No such file or directory`);
            return;
        }

        delete parentDir[fileName];
        this.saveFileSystem();
        this.displayOutput('');
    }

    grepFile(args) {
        if (args.length < 2) {
            this.displayOutput('grep: missing pattern and file operand');
            return;
        }

        const pattern = args[0];
        const filename = args[1];
        const filePath = this.resolvePath(filename);
        const content = this.getFileContent(filePath);
        
        if (content === null) {
            this.displayOutput(`grep: ${filename}: No such file or directory`);
            return;
        }

        const lines = content.split('\n');
        const regex = new RegExp(pattern, 'i');
        const matches = lines.filter(line => regex.test(line));
        
        if (matches.length > 0) {
            this.displayOutput(matches.join('\n'));
        } else {
            this.displayOutput('');
        }
    }

    sortFile(args) {
        if (args.length === 0) {
            this.displayOutput('sort: missing file operand');
            return;
        }

        const filename = args[0];
        const filePath = this.resolvePath(filename);
        const content = this.getFileContent(filePath);
        
        if (content === null) {
            this.displayOutput(`sort: cannot read: ${filename}: No such file or directory`);
            return;
        }

        const lines = content.split('\n');
        const sorted = lines.sort();
        this.displayOutput(sorted.join('\n'));
    }

    uniqFile(args) {
        if (args.length === 0) {
            this.displayOutput('uniq: missing file operand');
            return;
        }

        const filename = args[0];
        const filePath = this.resolvePath(filename);
        const content = this.getFileContent(filePath);
        
        if (content === null) {
            this.displayOutput(`uniq: cannot read: ${filename}: No such file or directory`);
            return;
        }

        const lines = content.split('\n');
        const unique = [];
        let lastLine = null;
        
        for (const line of lines) {
            if (line !== lastLine) {
                unique.push(line);
                lastLine = line;
            }
        }
        
        this.displayOutput(unique.join('\n'));
    }

    wcFile(args) {
        if (args.length === 0) {
            this.displayOutput('wc: missing file operand');
            return;
        }

        const filename = args[0];
        const filePath = this.resolvePath(filename);
        const content = this.getFileContent(filePath);
        
        if (content === null) {
            this.displayOutput(`wc: ${filename}: No such file or directory`);
            return;
        }

        const lines = content.split('\n').length;
        const words = content.trim().split(/\s+/).filter(word => word.length > 0).length;
        const chars = content.length;
        
        this.displayOutput(`${lines} ${words} ${chars} ${filename}`);
    }

    diffFiles(args) {
        if (args.length < 2) {
            this.displayOutput('diff: missing file operand');
            return;
        }

        const file1Path = this.resolvePath(args[0]);
        const file2Path = this.resolvePath(args[1]);
        const content1 = this.getFileContent(file1Path);
        const content2 = this.getFileContent(file2Path);
        
        if (content1 === null) {
            this.displayOutput(`diff: ${args[0]}: No such file or directory`);
            return;
        }
        
        if (content2 === null) {
            this.displayOutput(`diff: ${args[1]}: No such file or directory`);
            return;
        }

        if (content1 === content2) {
            this.displayOutput('');
        } else {
            this.displayOutput(`Files ${args[0]} and ${args[1]} differ`);
        }
    }

    findFiles(args) {
        if (args.length === 0) {
            this.displayOutput('find: missing path operand');
            return;
        }

        const searchPath = args[0] || this.currentDirectory;
        let pattern = '*';
        
        if (args.includes('-name') && args.length >= 3) {
            const nameIndex = args.indexOf('-name');
            pattern = args[nameIndex + 1];
        }

        const resolvedPath = this.resolvePath(searchPath);
        const results = this.searchInDirectory(resolvedPath, pattern);
        
        if (results.length > 0) {
            this.displayOutput(results.join('\n'));
        } else {
            this.displayOutput('');
        }
    }

    searchInDirectory(path, pattern) {
        const results = [];
        let current;
        
        if (path.includes('/')) {
            const parts = path.split('/');
            current = this.simulatedFileSystem;
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    return results;
                }
            }
        } else {
            if (!this.simulatedFileSystem[path]) {
                return results;
            }
            current = this.simulatedFileSystem[path].contents;
        }

        const regex = new RegExp(pattern.replace('*', '.*'), 'i');
        
        for (const [name, node] of Object.entries(current)) {
            if (regex.test(name)) {
                results.push(`${path}/${name}`);
            }
        }
        
        return results;
    }

    locateFile(args) {
        if (args.length === 0) {
            this.displayOutput('locate: missing pattern operand');
            return;
        }

        const pattern = args[0];
        const results = this.searchAllDirectories(pattern);
        
        if (results.length > 0) {
            this.displayOutput(results.join('\n'));
        } else {
            this.displayOutput('');
        }
    }

    searchAllDirectories(pattern) {
        const results = [];
        const regex = new RegExp(pattern.replace('*', '.*'), 'i');
        
        const searchRecursive = (path, node) => {
            if (node.type === 'directory') {
                for (const [name, childNode] of Object.entries(node.contents)) {
                    const fullPath = path === '~' ? `~/${name}` : `${path}/${name}`;
                    
                    if (regex.test(name)) {
                        results.push(fullPath);
                    }
                    
                    searchRecursive(fullPath, childNode);
                }
            }
        };
        
        for (const [name, node] of Object.entries(this.simulatedFileSystem)) {
            if (regex.test(name)) {
                results.push(name);
            }
            searchRecursive(name, node);
        }
        
        return results;
    }

    showTree(args) {
        const path = args[0] || this.currentDirectory;
        const resolvedPath = this.resolvePath(path);
        const treeOutput = this.generateTree(resolvedPath);
        this.displayOutput(treeOutput);
    }

    generateTree(path, prefix = '') {
        let current;
        
        if (path.includes('/')) {
            const parts = path.split('/');
            current = this.simulatedFileSystem;
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    return 'Error: Path not found';
                }
            }
        } else {
            if (!this.simulatedFileSystem[path]) {
                return 'Error: Path not found';
            }
            current = this.simulatedFileSystem[path].contents;
        }

        const entries = Object.entries(current);
        let result = '';
        
        entries.forEach(([name, node], index) => {
            const isLast = index === entries.length - 1;
            const currentPrefix = isLast ? '└── ' : '├── ';
            const nextPrefix = isLast ? '    ' : '│   ';
            
            result += prefix + currentPrefix + name;
            
            if (node.type === 'directory') {
                result += '/\n';
                if (Object.keys(node.contents).length > 0) {
                    result += this.generateTree(`${path}/${name}`, prefix + nextPrefix);
                }
            } else {
                result += '\n';
            }
        });
        
        return result;
    }

    showDiskUsage(args) {
        const path = args[0] || this.currentDirectory;
        const resolvedPath = this.resolvePath(path);
        const usage = this.calculateDirectorySize(resolvedPath);
        this.displayOutput(`${usage}K\t${path}`);
    }

    calculateDirectorySize(path) {
        let current;
        
        if (path.includes('/')) {
            const parts = path.split('/');
            current = this.simulatedFileSystem;
            for (const part of parts) {
                if (current[part] && current[part].type === 'directory') {
                    current = current[part].contents;
                } else {
                    return 0;
                }
            }
        } else {
            if (!this.simulatedFileSystem[path]) {
                return 0;
            }
            current = this.simulatedFileSystem[path].contents;
        }

        let size = 0;
        
        for (const [name, node] of Object.entries(current)) {
            if (node.type === 'file') {
                size += (node.content || '').length;
            } else if (node.type === 'directory') {
                size += this.calculateDirectorySize(`${path}/${name}`);
            }
        }
        
        return Math.ceil(size / 1024);
    }

    showDiskSpace(args) {
        const dfOutput = `
            Filesystem      Size  Used Avail Use% Mounted on
            /dev/sda1        50G   15G   33G  32% /
            /dev/sdb2       100G   45G   50G  48% /home
            tmpfs           2.0G     0  2.0G   0% /dev/shm
            `;
            this.displayOutput(dfOutput.trim());
        }
            
        showMemory(args) {
            const freeOutput = `
            total        used        free      shared  buff/cache  available
            Mem:        8192M       4096M       2048M        256M       2048M       4096M
            Swap:       4096M          0M       4096M
        `;
        this.displayOutput(freeOutput.trim());
    }

    wgetFile(args) {
        if (args.length === 0) {
            this.displayOutput('wget: missing URL');
            this.displayOutput('Usage: wget [URL]');
            return;
        }

        const url = args[0];
        
        let filename = 'downloaded_file';
        try {
            const urlObj = new URL(url);
            const pathname = urlObj.pathname;
            if (pathname && pathname !== '/') {
                filename = pathname.split('/').pop() || 'downloaded_file';
            }
        } catch (e) {
            const urlParts = url.split('/');
            filename = urlParts[urlParts.length - 1] || 'downloaded_file';
        }

        filename = filename.split('?')[0];

        this.displayOutput(`--2025-03-04 16:54:00--  ${url}`);
        this.displayOutput(`Resolving ${new URL(url).hostname} (${new URL(url).hostname})... ${new Date().toISOString().split('T')[1].split('.')[0]}`);
        this.displayOutput(`Connecting to ${new URL(url).hostname}|74.6.143.25|:443... connected.`);
        this.displayOutput(`HTTP request sent, awaiting response... 200 OK`);
        this.displayOutput(`Length: ${Math.floor(Math.random() * 1000000 + 500000)} [image/jpeg]`);
        this.displayOutput(`Saving to: '~/downloads/${filename}'`);

        const downloadsPath = '~/downloads';
        const filePath = `${downloadsPath}/${filename}`;
        
        let downloadsDir = this.simulatedFileSystem['~'].contents['downloads'].contents;

        downloadsDir[filename] = {
            type: 'file',
            content: `Downloaded from: ${url}\nDownloaded at: ${new Date().toString()}\nFile size: ${Math.floor(Math.random() * 1000000 + 500000)} bytes`
        };

        this.saveFileSystem();
        this.displayOutput(`100%[==============================>] 1,234,567  --.-KB/s    in 0.001s`);
        this.displayOutput(`'~/downloads/${filename}' saved [1,234,567/1,234,567]`);
    }

    displayImage(args) {
        if (args.length === 0) {
            this.displayOutput('display: missing file operand');
            this.displayOutput('Usage: display [image file]');
            return;
        }

        const filename = args[0];
        const filePath = this.resolvePath(filename);
        const content = this.getFileContent(filePath);
        
        if (content === null) {
            this.displayOutput(`display: cannot open '${filename}': No such file or directory`);
            return;
        }

        const imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp', '.webp', '.svg', '.ico'];
        const isImage = imageExtensions.some(ext => filename.toLowerCase().endsWith(ext));

        if (!isImage) {
            this.displayOutput(`display: '${filename}' is not an image file`);
            return;
        }

        let imageUrl = null;
        if (content.includes('Downloaded from:')) {
            const urlMatch = content.match(/Downloaded from: (.+)/);
            imageUrl = urlMatch ? urlMatch[1] : null;
        }

        if (!imageUrl) {
            this.displayOutput(`display: '${filename}' is not a downloaded image file`);
            return;
        }

        const output = document.getElementById('output');
        const imageDiv = document.createElement('div');
        imageDiv.className = 'fade-in mb-4';
        imageDiv.innerHTML = `
            <div class="bg-gray-800 p-4 rounded-lg">
                <div class="text-green-400 mb-2">🖼️ Displaying: ${filename}</div>
                <img src="${imageUrl}" alt="${filename}" class="max-w-full max-h-96 rounded-lg shadow-lg" 
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                     style="display: block;">
                <div class="text-red-400" style="display: none;">
                    ⚠️ Failed to load image: ${imageUrl}
                </div>
                <div class="text-gray-400 text-sm mt-2">
                    Original URL: <a href="${imageUrl}" target="_blank" class="text-blue-400 hover:text-blue-300">${imageUrl}</a>
                </div>
                <div class="text-gray-500 text-xs mt-2">
                    💡 Tip: Use 'cat ${filename}' to see download metadata
                </div>
            </div>
        `;
        output.appendChild(imageDiv);
        this.scrollToBottom();
    }

    showUname(args) {
        if (args.includes('-a')) {
            this.displayOutput('Linux console 5.15.0-generic #1 SMP Fri Dec 10 15:30:00 UTC 2023 x86_64 x86_64 x86_64 GNU/Linux');
        } else {
            this.displayOutput('Linux');
        }
    }

    showProcesses() {
        const processes = `
            PID TTY          TIME CMD
            1234 pts/0    00:00:01 bash
            5678 pts/0    00:00:00 node
            9012 pts/0    00:00:00 ps
        `;
        this.displayOutput(processes.trim());
    }

    showTop() {
        const topOutput = `
            top - 15:30:00 up 2 days,  3:45,  2 users,  load average: 0.15, 0.12, 0.08
            Tasks: 120 total,   1 running, 119 sleeping,   0 stopped,   0 zombie
            %Cpu(s):  5.2 us,  2.1 sy,  0.0 ni, 92.7 id,  0.0 wa,  0.0 hi,  0.0 si,  0.0 st
            MiB Mem :   8192.0 total,   2048.0 free,   4096.0 used,   2048.0 buff/cache
            MiB Swap:   4096.0 total,   4096.0 free,      0.0 used.   4096.0 avail Mem
                
                PID USER      PR  NI    VIRT    RES    SHR S  %CPU  %MEM     TIME+ COMMAND
               1234 user      20   0   1024    512    256 S   0.7   6.2   0:01.23 bash
               5678 user      20   0   2048   1024    512 S   0.3  12.5   0:00.45 node
        `;
        this.displayOutput(topOutput.trim());
    }

    showDiskUsage() {
        const dfOutput = `
            Filesystem      Size  Used Avail Use% Mounted on
            /dev/sda1        50G   15G   33G  32% /
            /dev/sdb2       100G   45G   50G  48% /home
            tmpfs           2.0G     0  2.0G   0% /dev/shm
        `;
        this.displayOutput(dfOutput.trim());
    }

    showMemory() {
        const freeOutput = `
            total        used        free      shared  buff/cache   available
            Mem:        8192M       4096M       2048M        256M       2048M       4096M
            Swap:       4096M          0M       4096M
        `;
        this.displayOutput(freeOutput.trim());
    }

    showUptime() {
        const uptime = Math.floor(Math.random() * 100000);
        const users = Math.floor(Math.random() * 5) + 1;
        const loadAvg = (Math.random() * 2).toFixed(2);
        this.displayOutput(` ${uptime} up 2 days, 3:45, ${users} users,  load average: ${loadAvg}, 0.12, 0.08`);
    }

    clearTerminal() {
        const output = document.getElementById('output');
        output.innerHTML = '';
        this.displayOutput('Terminal cleared. Type \'help\' for available commands.');
    }

    displayCommand(command) {
        const output = document.getElementById('output');
        const commandDiv = document.createElement('div');
        commandDiv.className = 'fade-in';
        commandDiv.innerHTML = `<span class="text-green-400">$</span> ${command}`;
        output.appendChild(commandDiv);
        this.scrollToBottom();
    }

    displayOutput(text) {
        const output = document.getElementById('output');
        const outputDiv = document.createElement('div');
        outputDiv.className = 'fade-in';
        outputDiv.textContent = text;
        output.appendChild(outputDiv);
        this.scrollToBottom();
    }

    scrollToBottom() {
        const output = document.getElementById('output');
        output.scrollTop = output.scrollHeight;
    }

    addToHistory(command) {
        this.commandHistory.push(command);
        this.updateHistoryDisplay();
    }

    updateHistoryDisplay() {
        const historyDiv = document.getElementById('history');
        if (this.commandHistory.length === 0) {
            historyDiv.innerHTML = '<div class="text-gray-400 text-sm">No commands yet...</div>';
            return;
        }

        const historyItems = this.commandHistory.slice(-10).reverse().map((cmd, index) => 
            `<div class="text-sm px-2 py-1 bg-gray-700 rounded hover:bg-gray-600 cursor-pointer" onclick="console.executeHistoryCommand('${cmd}')">${cmd}</div>`
        ).join('');
        
        historyDiv.innerHTML = historyItems;
    }

    executeHistoryCommand(command) {
        document.getElementById('commandInput').value = command;
        this.executeCommand();
    }

    clearHistory() {
        this.commandHistory = [];
        this.updateHistoryDisplay();
    }

    navigateHistory(direction) {
        if (this.commandHistory.length === 0) return;
        
        if (this.historyIndex === undefined) {
            this.historyIndex = this.commandHistory.length;
        }
        
        this.historyIndex += direction;
        
        if (this.historyIndex < 0) {
            this.historyIndex = 0;
        } else if (this.historyIndex >= this.commandHistory.length) {
            this.historyIndex = this.commandHistory.length;
            document.getElementById('commandInput').value = '';
            return;
        }
        
        document.getElementById('commandInput').value = this.commandHistory[this.historyIndex];
    }

    updateStats() {
        document.getElementById('commandCount').textContent = this.commandCount;
    }

    updateStatus(status) {
        const statusElement = document.getElementById('status');
        statusElement.textContent = status;
        
        if (status === 'Ready') {
            statusElement.className = 'text-green-400';
        } else if (status === 'Processing...') {
            statusElement.className = 'text-yellow-400';
        } else {
            statusElement.className = 'text-red-400';
        }
    }
}

let console;
document.addEventListener('DOMContentLoaded', () => {
    console = new LinuxConsole();
});
