 <div class="card shadow">
     <div class="card-header header-bg">
         <i class="fas fa-money-check-alt"></i> Add Meetings
     </div>
     <div class="card-body">
         <div class="row mt-3">
             <div class="col-12 mt-3">
                 <div class="form-group">
                     <label class="fw-bold mt-1">Meeting Name / Title <span class="text text-danger">*</span></label>
                     <input type="text" class="form-control" id="txtMeetingName">
                 </div>
             </div>
             <div class="col-12 mt-3">
                 <div class="form-group">
                     <label class="fw-bold mt-1">Date <span class="text text-danger">*</span></label>
                     <input type="date" class="form-control" id="txtDate">
                 </div>
             </div>
             <div class="col-12 mt-3">
                 <div class="form-group">
                     <label class="fw-bold mt-1">Time <span class="text text-danger">*</span></label>
                     <input type="time" class="form-control" id="txtTime">
                 </div>
             </div>
             <div class="col-12 mt-3">
                 <div class="form-group">
                     <label class="fw-bold mt-1">Special Guest</label>
                     <input type="text" class="form-control" id="txtSpecialGuest">
                 </div>
             </div>
             <div class="col-12 mt-3">
                 <div class="form-group">
                     <label class="fw-bold mt-1">Remarks</label>
                     <textarea id="Remarks" class="form-control"></textarea>
                 </div>
             </div>
             <div class="col-12 mt-3">
                 <div class="form-group">
                     <label class="fw-bold mt-1">Branch</label>
                     <select id="txtBranch" class="form-control">
                         <option value="" readonly>---Select---</option>
                         <?php
                            try {
                                $sqlPMethod = "SELECT * FROM tbl_branch where active = 'Yes'";
                                $stmt = $db->prepare($sqlPMethod);
                                $stmt->execute();
                                $i = 1;
                                while ($row = $stmt->fetchObject()) {
                                    $id = $row->id;
                                    $branchName = $row->branchName;
                                    echo "<option value='$id'>$branchName</option>";
                                }
                            } catch (PDOException $e) {
                                echo $e->getMessage();
                            }
                            ?>
                     </select>
                 </div>
             </div>
             <div class="row mt-3">
                 <div id="viewClient"></div>
             </div>
         </div>
         <div class="row-2 mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" id="btnMeetingSubmit">
                Submit
            </button>
         </div>
     </div>
 </div>

 <!-- Custom JS -->
 <script src='../../js/custom/meeting-settings.js?v=<?= $cashClear ?>'></script>
 <!-- Custom JS -->