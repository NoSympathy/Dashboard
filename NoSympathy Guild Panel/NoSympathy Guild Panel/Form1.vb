Imports Models
Imports Newtonsoft.Json

Public Class Form1
    Dim count As Integer
    Dim members As List(Of Member)

    Private Sub PopulateGuildMembers()
        'Dim controllers = New APIControllers.GuildController()
        'Dim jsonString As String
        'Dim members = controllers.GetGuildMembers()

        DataGridView1.DataSource = members
    End Sub
    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        Me.Text = "NoSympathy Guild Panel"

        Dim controllers = New APIControllers.GuildController()
        'Dim jsonString As String


        members = controllers.GetGuildMembers()



        For Each member As Member In members
            'ListView1.Items.Add(member.Name, member.Name + "-" + member.Rank)
        Next

        count = members.Count

        lblCountMember.Text = "We have " + count.ToString() + " NoS Members Today!"
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Settings.Show()
    End Sub

    Private Sub LinkLabel1_LinkClicked(sender As Object, e As LinkLabelLinkClickedEventArgs) Handles LinkLabel1.LinkClicked
        Personal.Show()
    End Sub

    Private Sub TabControl4_Selected(sender As Object, e As TabControlEventArgs) Handles TabControl1.Selected
        If e.TabPageIndex = 0 Then ''add welcome message here

        ElseIf e.TabPageIndex = 1 Then ''music playlist here

        ElseIf e.TabPageIndex = 2 Then '' NOS information here

        ElseIf e.TabPageIndex = 3 Then '' Guild members here
            PopulateGuildMembers()
        ElseIf e.TabPageIndex = 4 Then '' support here 

        ElseIf e.TabPageIndex = 5 Then '' About here

        ElseIf e.TabPageIndex = 6 Then '' Extras here

        End If
        WebControl1.Source = New Uri("http://gw2timer.com/?page=Tile")
    End Sub

    Private Sub TabControl2_Selected(sender As Object, e As TabControlEventArgs) Handles TabControl1.Selected
        WebControl2.Source = New Uri("http://www.youtube.com/embed?listType=playlist&list=PLfhuRJY8whYCPeUgZRM2Gkm_lirSUPMfP")
    End Sub


    Private Sub ListView1_SelectedIndexChanged(sender As Object, e As EventArgs)

    End Sub

    Private Sub DataGridView1_CellContentClick(sender As Object, e As DataGridViewCellEventArgs) Handles DataGridView1.CellContentClick

    End Sub

    
End Class
