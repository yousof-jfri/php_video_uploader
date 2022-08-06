// variables form
const form = document.querySelector('#upload');
const progress = document.querySelector('#progress');
const progressBar = progress.querySelector('#progress-bar');
const progressNum = progress.querySelector('#progress-number');
const successMessage = document.querySelector('#success-message');

const getVideosBtn = document.querySelector('#get-videos');

// event listeners
form.addEventListener('submit', (e) => submitForm(e))
getVideosBtn.addEventListener('click', fetchVideos)


// functions
function submitForm(e)
{
    e.preventDefault();
    let video = form.querySelector(`input[name='file']`).files[0];
    let name = form.querySelector(`input[name='name']`).value;

    // check the video exists or not
    if(video)
    {
        let formData = new FormData();
        formData.append('file', video);
        formData.append('name', name);
        console.log(formData)  

        // send ajax request
        let xhr = new XMLHttpRequest();

        xhr.upload.addEventListener('progress', progressHandler);

        xhr.addEventListener('load', completeHandler)

        xhr.open('POST', '/php_project/video_uploader/proccess/proccess.php', true)
        xhr.send(formData)
    }
}

function completeHandler()
{
    // show progress bar
    progress.classList.add('hidden');
    successMessage.classList.remove('hidden')
    
    setTimeout(() => {
        successMessage.classList.add('hidden')
    }, 3000)
}

function progressHandler(e)
{
    progress.classList.remove('hidden');
    let percent = (e.loaded / e.total) * 100;
    progressBar.style.width = percent + '%';
    progressNum.innerHTML = Math.floor(percent) + '%';
}


// fetch videos
function fetchVideos()
{
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '/php_project/video_uploader/proccess/allVideos.php', true);

    xhr.onreadystatechange = function(){
        if(this.status == 200) {
            
            let data = [];
            data = xhr.responseText;
            data = JSON.parse(xhr.responseText);
            setVideos(data)
        }
    }
    xhr.send();
}

function setVideos(res)
{
    let htmlTemplate =  ``;

    res.forEach(videos => { 
        console.log(videos.name)
        htmlTemplate += `
            <div class="col-span-1">
                <div class="relative w-full h-32 bg-white border rounded-xl overflow-hidden text-center">
                    <video width="320" height="240" class="h-5/6 object-cover">
                        <source src="./../proccess/videos/${videos.video}" type="video/mp4">
                        <source src="./../proccess/videos/${videos.video}" type="video/ogg">
                        Your browser does not support the video tag.
                    </video>
                    <div class="w-full h-1/6 text-center flex items-center justify-center">
                        <a href="./video.php?id=${videos.id}">${videos.name}</a>
                    </div>
                </div>
            </div>
        `;
    });

    const videoContainer = document.querySelector('#videos-container');
    videoContainer.innerHTML = htmlTemplate;
}