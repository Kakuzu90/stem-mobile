
@switch(request()->route()->getName())
    @case('admin.school-year.index')
        @include('modals.admin.year.add')
        @include('modals.admin.year.edit')
    @break

    @case('admin.grade-level.index')
        @include('modals.admin.grade.add')
        @include('modals.admin.grade.edit')
    @break

    @case('admin.sections.index')
        @include('modals.admin.section.add')
        @include('modals.admin.section.edit')
    @break

    @case('admin.classrooms.index')
        @include('modals.admin.classroom.add')
        @include('modals.admin.classroom.edit')
        @include('modals.admin.classroom.subject')
    @break

    @case('admin.subjects.index')
        @include('modals.admin.subject.add')
        @include('modals.admin.subject.edit')
    @break

    @case('admin.teachers.index')
        @include('modals.admin.teacher.add')
        @include('modals.admin.teacher.edit')
        @include('modals.admin.teacher.import')
    @break

    @case('admin.students.index')
        @include('modals.admin.student.add')
        @include('modals.admin.student.edit')
        @include('modals.admin.student.import')
    @break

    @case('admin.announcements.index')
        @include('modals.admin.announcement.add')
        @include('modals.admin.announcement.edit')
    @break

    @case('admin.modules.index')
        @include('modals.admin.module.add')
        @include('modals.admin.module.edit')
    @break

    @case('admin.activities.index')
        @include('modals.admin.activity.add')
        @include('modals.admin.activity.edit')
    @break

    @case('teacher.announcements.index')
        @include('modals.teacher.announcement.add')
        @include('modals.teacher.announcement.edit')
    @break

    @case('teacher.modules.index')
        @include('modals.teacher.module.add')
        @include('modals.teacher.module.edit')
    @break

    @case('teacher.quiz.index')
        @include('modals.teacher.quiz.add')
        @include('modals.teacher.quiz.edit')
    @break

    @case('teacher.assignments.index')
        @include('modals.teacher.assignment.add')
        @include('modals.teacher.assignment.edit')
    @break

    @case('teacher.students.index')
        @include('modals.teacher.student.add')
        @include('modals.teacher.student.edit')
    @break
        
    @default

@endswitch

@if (!in_array(request()->route()->getName(), ['admin.dashboard', 'teacher.dashboard']))
    @include('modals.delete')
@endif

