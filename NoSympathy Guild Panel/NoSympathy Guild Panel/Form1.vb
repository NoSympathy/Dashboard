Imports Models
Imports Newtonsoft.Json




Public Class Form1
    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        Me.Text = "NoSympathy Guild Panel"

        Dim controllers = New APIControllers.GuildController()
        Dim jsonString As String
        Dim members As List(Of Member)

        jsonString = controllers.GetGuildMembers("90F665FE-7C84-B044-BBBF-A14439C03954B8E980F3-C188-4FE3-8365-D787865D0C77")

        members = JsonConvert.DeserializeObject(Of List(Of Member))(jsonString)

        For Each member As Member In members
            ListView1.Items.Add(member.Name, member.Name + "-" + member.Rank)
        Next
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Settings.Show()
    End Sub

    Private Sub LinkLabel1_LinkClicked(sender As Object, e As LinkLabelLinkClickedEventArgs) Handles LinkLabel1.LinkClicked
        Personal.Show()
    End Sub

    Private Sub ListView1_SelectedIndexChanged(sender As Object, e As EventArgs) Handles ListView1.SelectedIndexChanged
        
    End Sub
End Class
