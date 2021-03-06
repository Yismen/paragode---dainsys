<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-envelope-o"></i>
      <span class="label label-success">4</span>
    </a>
    <ul class="dropdown-menu">
      <li class="header">You have 4 messages

        <a href="/admin/messages/create" class="pull-right">
            <i class="fa fa-plus"></i>
        </a>
      </li>
      <li>
        {{-- For each unread message, loop --}}
        <!-- inner menu: contains the messages -->
            <ul class="menu">
              <li><!-- start message -->
                <a href="#">
                  <div class="pull-left">
                    <!-- User Image -->
                    @include('layouts.partials.user-photo')
                  </div>
                  <!-- Message title and timestamp -->
                  <h4>
                    Support Team
                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                  </h4>
                  <!-- The message -->
                  <p>Why not buy a new awesome theme?</p>
                </a>
              </li>
              <!-- end message -->
            </ul>
            <!-- /.menu -->
      </li>
      
      <li class="footer"><a href="/admin/messages">See All Messages</a></li>
    </ul>
  </li>
  <!-- /.messages-menu -->