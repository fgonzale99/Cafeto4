import React, { Component, Suspense, lazy  } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Switch, Route, Link} from "react-router-dom";

const List = lazy(() => import('../components/crud/List'));
const New = lazy(() => import('../components/crud/New'));
const Edit = lazy(() => import('../components/crud/Edit'));
const Show = lazy(() => import('../components/crud/Show'));
const Board = lazy(() => import('../components/crud/Board'));
const FormReviewNew = lazy(() => import('./review/form/New'));
const FormReviewEdit = lazy(() => import('./review/form/Edit'));
const Questions = lazy(() => import('./review/form/Questions'));
const Publish = lazy(() => import('./review/form/Publish'));
const FormReviewShow = lazy(() => import('./review/form/Show'));
const Rules = lazy(() => import('./review/form/Rules'));

const ReviewPage = lazy(() => import('./review/eval/Page'));
const ReviewStart = lazy(() => import('./review/eval/Start'));
const ReviewEval = lazy(() => import('./review/eval/Eval'));
const ReviewSummary = lazy(() => import('./review/eval/Summary'));
const ReviewFinish = lazy(() => import('./review/eval/Finish'));
const ReviewerProjects = lazy(() => import('./reviewer/Projects'));
const ReviewerSearch = lazy(() => import('./reviewer/Search'));
const ReviewTrack = lazy(() => import('./review/Track'));
const ReviewList = lazy(() => import('./review/List'));
const ReviewEditassign = lazy(() => import('./review/Editassign'));
const ReviewBoard = lazy(() => import('./review/Board'));


const ReviewAuditassign = lazy(() => import('./review/Auditassign'));
const ReviewAuditassignEdit = lazy(() => import('./review/Auditassignedit'));
const ReviewAudit = lazy(() => import('./review/Audit'));
const ReviewPaymentProfile = lazy(() => import('./review/PaymentProfile'));
const ReviewPaymentRequest = lazy(() => import('./review/PaymentRequest'));

const ProjectNew = lazy(() => import('./project/New'));
const ProjectEdit = lazy(() => import('./project/Edit'));
const ProjectReviewer= lazy(() => import('./project/Reviewer'));
const ProjectBoard = lazy(() => import('./project/Board'));


const ProcessNew = lazy(() => import('./process/New'));
const ProcessList = lazy(() => import('./process/Crud/List'));
const ProcessTopBudget = lazy(() => import('./process/TopBudget'));
const ProcessBudget = lazy(() => import('./process/Budget'));
const ProcessEdit = lazy(() => import('./process/Edit'));
const ProcessBoard = lazy(() => import('./process/Board'));
const ProcessPaymentList = lazy(() => import('./process/PaymentList'));

const CommitteeReviewList = lazy(() => import('./committee/ReviewList'));
const CommitteeReviewEval = lazy(() => import('./committee/ReviewEval'));
const CommitteeAuditShow = lazy(() => import('./committee/ReviewShow'));
const CommitteeAuditSummary = lazy(() => import('./committee/AuditSummary'));
const CommitteeReviewSummary = lazy(() => import('./committee/ReviewSummary'));
const CommitteeReviewer = lazy(() => import('./committee/ReviewerShow'));

const CustomerDashboard = lazy(() => import('./customer/dashboard/Dashboard'));
const CustomerProcessList = lazy(() => import('./customer/process/List'));
const CustomerProcessBoard = lazy(() => import('./customer/process/Board'));
//const CustomerProjectList = lazy(() => import('./customer/project/List'));
const CustomerProjectBoard = lazy(() => import('./customer/project/Board'));
const CustomerReviewBoard = lazy(() => import('./customer/review/Board'));
//const CustomerReviewList = lazy(() => import('./customer/review/List'));
//const CustomerReviewDashboard  = lazy(() => import('./customer/review/Dashboard'));

const UserProfileEdit = lazy(() => import('./user/Edit'));
const UserProfileShow = lazy(() => import('./user/Show'));
const UserProfileDocuments= lazy(() => import('./user/Documents'));


const ManagerDashboard = lazy(() => import('./customer/dashboard/Dashboard'));


const NotificationBoard = lazy(() => import('./notification/Board'));
const MessageNew = lazy(() => import('./notification/message/New'));

const NotificationBubble = import('../components/general/NotificationBubble');

function Cafeto(){

  return (
    <>
      <Router>
        <main>
          <Suspense fallback={<div>Cafeto...</div>}>
            <Switch>

              <Route path="/crud/:module?/list" component={ List } />
              <Route path="/crud/:module?/new" component={ New } />
              <Route path="/crud/:module?/edit/:id" component={ Edit } />
              <Route path="/crud/:module?/show/:id" component={ Show } />
              <Route path="/crud/:module?/board/:id" component={ Board } />

              <Route path="/project/new/" component={ ProjectNew } />
              <Route path="/project/reviewer/:id" component={ ProjectReviewer } />
              <Route path="/project/edit/:id" component={ ProjectEdit } />
              <Route path="/project/board/:id" component={ ProjectBoard } />

              <Route path="/process/new" component={ ProcessNew } />
              <Route path="/process/budget/:id" component={ ProcessBudget } />
              <Route path="/process/edit/:id" component={ ProcessEdit } />
              
              
              
              <Route path="/process/list" component={ ProcessList } />
              <Route path="/process/topBudget/:id" component={ ProcessTopBudget } />
              <Route path="/process/board/:id" component={ ProcessBoard } />
              <Route path="/process/payment/list/:id" component={ ProcessPaymentList } />


              <Route path="/customer/dashboard" component={ CustomerDashboard } />

              <Route path="/formreview/new" component={ FormReviewNew } />
              <Route path="/formreview/questions/:id/:page?" component={ Questions } />
              <Route path="/formreview/publish/:id" component={ Publish } />
              <Route path="/formreview/rules/:id" component={ Rules } />
              <Route path="/formreview/edit/:id/" component={ FormReviewEdit } />
              <Route path="/formreview/show/:id" component={ FormReviewShow } />

              <Route path="/review/form/:id/:page?" component={ ReviewPage } />
              <Route path="/review/eval/:id" component={ ReviewEval } />
              <Route path="/review/start/:id" component={ ReviewStart } />
              <Route path="/review/summary/:id" component={ ReviewSummary } />
              <Route path="/review/board/:id" component={ ReviewBoard } />
              <Route path="/review/finish/:id" component={ ReviewFinish } />
              <Route path="/review/track/:id" component={ ReviewTrack } />
              <Route path="/review/list/" component={ ReviewList } />
              <Route path="/review/editassign/:id" component={ ReviewEditassign } />
              <Route path="/review/auditassign/:id" component={ ReviewAuditassign } />
              <Route path="/review/auditassignedit/:id" component={ ReviewAuditassignEdit } />
              <Route path="/review/audit/:id" component={ ReviewAudit } />
              <Route path="/review/payment/profile/:id" component={ ReviewPaymentProfile } />
              <Route path="/review/payment/request/:id" component={ ReviewPaymentRequest } />


              <Route path="/reviewer/search" component={ ReviewerSearch } />
              <Route path="/reviewer/projects" component={ ReviewerProjects } />

              <Route path="/committee/review/list" component={ CommitteeReviewList } />
              <Route path="/committee/review/eval/:id" component={ CommitteeReviewEval } />
              <Route path="/committee/audit/show/:id" component={ CommitteeAuditShow } />
              <Route path="/committee/audit/summary/:id" component={ CommitteeAuditSummary } />
              <Route path="/committee/summary/:id" component={ CommitteeReviewSummary } />
              <Route path="/committee/reviewer/:id" component={ CommitteeReviewer } />


              <Route path="/customer/process/list" component={ CustomerProcessList } />
              <Route path="/customer/process/board/:id" component={ CustomerProcessBoard } />
              <Route path="/customer/project/board/:id" component={ CustomerProjectBoard } />
              <Route path="/customer/review/board/:id" component={ CustomerReviewBoard } />

              <Route path="/user/profile/edit" component={ UserProfileEdit } />
              <Route path="/user/profile/show" component={ UserProfileShow } />
              <Route path="/user/profile/documents" component={ UserProfileDocuments } />

              <Route path="/notification/board/:id" component={ NotificationBoard } />
              <Route path="/message/new/:id" component={ MessageNew } />

            </Switch>
          </Suspense>
        </main>
      </Router>
    </>
  )
}

export default Cafeto;
ReactDOM.render(<Cafeto />, document.getElementById('main-app'));
