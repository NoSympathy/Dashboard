Imports Models
Imports Newtonsoft.Json




Public Class Form1
    Dim count As Integer
    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        Me.Text = "NoSympathy Guild Panel"

        Dim controllers = New APIControllers.GuildController()
        'Dim jsonString As String
        Dim members As List(Of Member)

        members = controllers.GetGuildMembers("90F665FE-7C84-B044-BBBF-A14439C03954B8E980F3-C188-4FE3-8365-D787865D0C77")



        For Each member As Member In members
            ListView1.Items.Add(member.Name, member.Name + "-" + member.Rank)
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

    Private Sub ListView1_SelectedIndexChanged(sender As Object, e As EventArgs) Handles ListView1.SelectedIndexChanged

    End Sub

    Private Sub TabControl5_Selected(sender As Object, e As TabControlEventArgs) Handles TabControl1.Selected
        WebControl1.Source = New Uri("http://gw2timer.com/?page=Tile")
    End Sub

    Private Sub TabControl2_Selected(sender As Object, e As TabControlEventArgs) Handles TabControl1.Selected
        WebControl2.Source = New Uri("http://www.youtube.com/embed?listType=playlist&list=PLfhuRJY8whYCPeUgZRM2Gkm_lirSUPMfP")
    End Sub

    Private Sub Button2_Click(sender As Object, e As EventArgs) Handles Button2.Click
        WebControl2.Source = New Uri("http://www.youtube.com/embed?listType=playlist&list=PLfhuRJY8whYCPeUgZRM2Gkm_lirSUPMfP")
        music.Show()

    End Sub

End Class
