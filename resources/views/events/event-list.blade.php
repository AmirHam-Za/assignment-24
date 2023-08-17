<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="btn btn-sm  btn-success float-end btn m-0 btn-sm bg-gradient-primary">Add event</button>

                    <div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Event</h5>
                                </div>
                                <div class="modal-body">
                                    <form id="save-form">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12 p-1">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" class="form-control" id="title">
                                                </div>
                                                <div class="col-12 p-1">
                                                    <label class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="description">
                                                </div>
                                                <div class="col-12 p-1">
                                                    <label class="form-label">Date</label>
                                                    <input type="text" class="form-control" id="date">
                                                </div>
                                                <div class="col-12 p-1">
                                                    <label class="form-label">Time</label>
                                                    <input type="text" class="form-control" id="time">
                                                </div><div class="col-12 p-1">
                                                    <label class="form-label">Location</label>
                                                    <input type="text" class="form-control" id="location">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                    <button onclick="EventAdd()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="updated-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Event</h5>
                                </div>
                                <div class="modal-body">
                                    <form id="update-form">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12 p-1">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" class="form-control" id="update-title">
                                                    <input class="d-none" id="updateID">
                                                </div>
                                                <div class="col-12 p-1">
                                                    <label class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="update-description">
                                                </div>
                                                <div class="col-12 p-1">
                                                    <label class="form-label">Date</label>
                                                    <input type="text" class="form-control" id="update-date">
                                                </div>
                                                <div class="col-12 p-1">
                                                    <label class="form-label">Time</label>
                                                    <input type="text" class="form-control" id="update-time">
                                                </div><div class="col-12 p-1">
                                                    <label class="form-label">Location</label>
                                                    <input type="text" class="form-control" id="update-location">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                    <button onclick="EventUpdate()" id="save-btn" class="btn btn-sm  btn-success" >Update</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Vanue</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const getEvents = async (id)=> {
        let res=await axios.get("/events");

        let tableList = document.getElementById('tableList');

        tableList.innerHTML = '';

        res.data.forEach(function (item,index) {
            let row=`<tr>
                    <td>${index+1}</td>
                    <td>${item['title']}</td>
                    <td>${item['description']}</td>
                    <td>${item['date']}</td>
                    <td>${item['time']}</td>
                    <td>${item['location']}</td>
                    <td>
                        <button onclick="updateIdPass(${item['id']})" data-bs-toggle="modal" data-bs-target="#updated-modal" class="btn btn-sm btn-success  bg-gradient-primary">Edit</button> <button class="btn btn-sm btn-danger" onclick="EventDelete(${item['id']})">Delete</button>
                    </td>
                </tr>`

            tableList.innerHTML += row;
        })
    }
    getEvents();

    const EventAdd = async ()=> {
        let title = document.getElementById('title').value;
        let description = document.getElementById('description').value;
        let date = document.getElementById('date').value;
        let time = document.getElementById('time').value;
        let location = document.getElementById('location').value;

        if (title.length === 0) {
            alert("Category Required !")
        }
        if (description.length === 0) {
            alert("Description Required !")
        }
        if (date.length === 0) {
            alert("Date Required !")
        }
        if (time.length === 0) {
            alert("Time Required !")
        }
        if (location.length === 0) {
            alert("Location Required !")
        }
        else {

            document.getElementById('modal-close').click();

            let res = await axios.post("/events",{
                title:title,
                description:description,
                date:date,
                time:time,
                location:location,
            })

            if(res.status===201){
                document.getElementById("save-form").reset();
                await getEvents();
            }
            else{
                alert("Request fail !")
            }
        }
    }

    const updateIdPass =async (id) => {
        document.getElementById("updateID").value = id;

        let res = await axios.get(`/events/${id}`);
        if(res) {
            document.getElementById('update-title').value = res.data.title;
            document.getElementById('update-description').value = res.data.description;
            document.getElementById('update-date').value = res.data.date;
            document.getElementById('update-time').value = res.data.time;
            document.getElementById('update-location').value = res.data.location;
        }
    }

    const EventUpdate = async ()=> {
        let id = document.getElementById("updateID").value;
        let title = document.getElementById('update-title').value;
        let description = document.getElementById('update-description').value;
        let date = document.getElementById('update-date').value;
        let time = document.getElementById('update-time').value;
        let location = document.getElementById('update-location').value;

        if (title.length === 0) {
            alert("Category Required !")
        }
        if (description.length === 0) {
            alert("Description Required !")
        }
        if (date.length === 0) {
            alert("Date Required !")
        }
        if (time.length === 0) {
            alert("Time Required !")
        }
        if (location.length === 0) {
            alert("Location Required !")
        }
        else {

            document.getElementById('update-modal-close').click();

            let res = await axios.patch(`/events/${id}`,{
                title:title,
                description:description,
                date:date,
                time:time,
                location:location,
            })

            if(res.data==1){
                document.getElementById("update-form").reset();
                await getEvents();
            }
            else{
                alert("Request fail !")
            }
        }
    }

    const EventDelete = async (id)=> {
        let res=await axios.delete(`/events/${id}`)
        if(res.data===1){
            await getEvents();
        }
        else{
            alert("Request fail!")
        }
    }
</script>
