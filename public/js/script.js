const video = document.getElementById("video");

Promise.all([
  faceapi.nets.tinyFaceDetector.loadFromUri("./models"),
  faceapi.nets.faceLandmark68Net.loadFromUri("./models"),
  faceapi.nets.faceRecognitionNet.loadFromUri("./models"),
  faceapi.nets.ssdMobilenetv1.loadFromUri("./models"),
]).then(startVideo);

function startVideo() {
  navigator.getUserMedia(
    { video: {} },
    (stream) => (video.srcObject = stream),
    (err) => console.error(err)
  );
  recognize();
}

async function recognize() {
  clock();
  const labeledFace = await loadFaceData(); // lay dac duc khuon mat cua anh mau
  const faceMatcher = new faceapi.FaceMatcher(labeledFace, 0.5); // gan vao bien trung gian de so sanh
  // console.log(labeledFace);

  const canvas = faceapi.createCanvasFromMedia(video);
  document.getElementById("canvas").append(canvas);
  const displaySize = { width: video.width, height: video.height };
  faceapi.matchDimensions(canvas, displaySize);
  setInterval(async () => {
    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptors(); // lay dac trung trong camera
    // console.log(detections);
    const resizedDetections = faceapi.resizeResults(detections, displaySize); // chinh lai hinh
    canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
    const results = resizedDetections.map((d) =>faceMatcher.findBestMatch(d.descriptor)); // so sanh anh trong CSDL voi hinh trong camera
    results.forEach((result, i) => {
      const box = resizedDetections[i].detection.box;
      const drawBox = new faceapi.draw.DrawBox(box, {label: result.toString(),});
      drawBox.draw(canvas);
      if (result.label != "unknown") {
        let studentId = result.label
        let timeRollCall = $("#clock").attr('data-id');

        var data = {
          studentId : studentId,
          timeRollCall : timeRollCall
        }
        $.ajax({
          url: "?mod=users&action=rollCall",
          method: "POST",
          data: data,
          dataType: "json",
          success: function (data) {
            console.log(data)
            let timeRollCall = data.time_roll_call
            let studentId = data.student_id
            let selector_str = "li[data-id ='" + studentId + "']"

            if(timeRollCall == 0){
              $(selector_str).addClass('active')
            }else if(timeRollCall == 1){
              $(selector_str).addClass('active-late')
            }
          },
        });
      }
    });
  }, 500);
}

async function loadFaceData() {
  const labels = await getDataStudent();
  return Promise.all(
    labels.map(async (label) => {
      const listFace = []; // tao mang chua mo ta
      for (let i = 1; i <= 2; i++) {
        const img = await faceapi.fetchImage(`./public/images/${label}/${i}.jpg`); // lay hinh trong CSDL
        const faceDetect = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor(); // lay mo ta hinh mau
        listFace.push(faceDetect.descriptor);
      }
      return new faceapi.LabeledFaceDescriptors(label, listFace); // tra ket qua hinh mau da gan label
    })
  );
}

function getDataStudent(){
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "?mod=users&action=getDataStudent",
      method: "POST",
      data: "",
      dataType: "json",
      success: function (data) {
        var result = []
        for(let i = 0; i < data.length; i++) {
          result.push(data[i]['student_id'])
        }
        resolve(result)
    },
    });
  })
}

function clock() {
  var h = $(".hour span").text();
  var m = $(".minute span").text();
  var s = $(".second span").text();

  if ((h == 0) & (m == 0) & (s == 0)) {
    startClock();
  }
}

function startClock() {
  var h = 0, m = 0, s = 0, timeRollCall = 0;
  setInterval(function () {
    s += 1
    $(".second span").text(s)

    if(m == 15){
      $("#clock").attr('data-id', '1');
    }

    if ((s == 60)) {
      s = 0
      m += 1
      $(".minute span").text(m)
      $(".second span").text(s)
    }
    if ((m == 60)) {
      s = 0
      m = 0
      h+=1
      $(".hours span").text(h)
      $(".minute span").text(m)
      $(".second span").text(s)
    }
    
  }, 1);
}

