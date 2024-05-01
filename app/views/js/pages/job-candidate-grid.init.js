var url="http://localhost/multimarket/app/views/json/",allcandidateList="",prevButton=document.getElementById("page-prev"),nextButton=document.getElementById("page-next"),currentPage=1,itemsPerPage=20,getJSON=function(e,t){var a=new XMLHttpRequest;a.open("GET",url+e,!0),a.responseType="json",a.onload=function(){var e=a.status;t(200===e?null:e,a.response)},a.send()};function loadCandidateListData(e,t){var a=Math.ceil(e.length/itemsPerPage);a<(t=t<1?1:t)&&(t=a),document.querySelector("#candidate-list").innerHTML="";for(var n,i=(t-1)*itemsPerPage;i<t*itemsPerPage&&i<e.length;i++)e[i]&&(n=e[i].userImg?'<img src="'+e[i].userImg+'" alt="" class="member-img img-fluid d-block rounded" />':'<div class="avatar-title border bg-light text-primary rounded text-uppercase fs-24">'+e[i].nickname+"</div>",document.querySelector("#candidate-list").innerHTML+='<div class="col-xxl-3 col-md-6">    <div class="card">        <div class="card-body">            <div class="d-flex align-items-center">                <div class="flex-shrink-0">                    <div class="avatar-lg rounded">'+n+'</div>                </div>                <div class="flex-grow-1 ms-3">                    <a href="pages-profile.html">                        <h5 class="fs-16 mb-1">'+e[i].candidateName+'</h5>                    </a>                    <p class="text-muted mb-2">'+e[i].designation+'</p>                    <div class="d-flex flex-wrap gap-2 align-items-center">                    <div class="badge text-bg-success"><i class="mdi mdi-star me-1"></i>'+e[i].rating[0]+'</div>                        <div class="text-muted">'+e[i].rating[1]+'</div>                    </div>                    <div class="d-flex gap-4 mt-2 text-muted">                        <div>                            <i class="ri-map-pin-2-line text-primary me-1 align-bottom"></i> '+e[i].location+'</div>                        <div>                            <i class="ri-time-line text-primary me-1 align-bottom"></i>'+isStatus(e[i].type)+"                        </div>                    </div>                </div>            </div>        </div>    </div></div>");selectedPage(),1==currentPage?prevButton.parentNode.classList.add("disabled"):prevButton.parentNode.classList.remove("disabled"),currentPage==a?nextButton.parentNode.classList.add("disabled"):nextButton.parentNode.classList.remove("disabled")}function isStatus(e){switch(e){case"Part Time":return'<span class="badge bg-danger-subtle text-danger">'+e+"</span>";case"Full Time":return'<span class="badge bg-success-subtle text-success">'+e+"</span>";case"Freelancer":return'<span class="badge bg-secondary-subtle text-secondary">'+e+"</span>"}}function selectedPage(){for(var e=document.getElementById("page-num").getElementsByClassName("clickPageNumber"),t=0;t<e.length;t++)t==currentPage-1?e[t].parentNode.classList.add("active"):e[t].parentNode.classList.remove("active")}function paginationEvents(){function e(){return Math.ceil(allcandidateList.length/itemsPerPage)}prevButton.addEventListener("click",function(){1<currentPage&&loadCandidateListData(allcandidateList,--currentPage)}),nextButton.addEventListener("click",function(){currentPage<e()&&loadCandidateListData(allcandidateList,++currentPage)});var t=document.getElementById("page-num");t.innerHTML="";for(var a=1;a<e()+1;a++)t.innerHTML+="<div class='page-item'><a class='page-link clickPageNumber' href='javascript:void(0);'>"+a+"</a></div>";document.addEventListener("click",function(e){"A"==e.target.nodeName&&e.target.classList.contains("clickPageNumber")&&(currentPage=e.target.textContent,loadCandidateListData(allcandidateList,currentPage))}),selectedPage()}getJSON("job-candidate-list.json",function(e,t){null!==e?console.log("Something went wrong: "+e):(loadCandidateListData(allcandidateList=t,currentPage),paginationEvents())});var searchElementList=document.getElementById("searchJob");searchElementList.addEventListener("keyup",function(){var e=searchElementList.value.toLowerCase();t=e;for(var t,e=allcandidateList.filter(function(e){return-1!==e.designation.toLowerCase().indexOf(t.toLowerCase())||-1!==e.candidateName.toLowerCase().indexOf(t.toLowerCase())}),a=(0==e.length?document.getElementById("pagination-element").style.display="none":document.getElementById("pagination-element").style.display="flex",document.getElementById("page-num")),n=(a.innerHTML="",Math.ceil(e.length/itemsPerPage)),i=1;i<n+1;i++)a.innerHTML+="<div class='page-item'><a class='page-link clickPageNumber' href='javascript:void(0);'>"+i+"</a></div>";loadCandidateListData(e,currentPage)});